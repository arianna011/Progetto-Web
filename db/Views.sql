/*
Lo scopo di queste view è nascondere la struttura del database alle applicazioni php, in modo che possano essere modificate indipendentemente

cose da evitare durante definizione di view:
- Defining many layers of views so that your final queries look deceptively simple:
	Problems arise when you try to enhance or troubleshoot queries that use the views, for example by examining the execution plan. The query's execution plan tends to be complicated and it is difficult to understand and how to improve it.

-Defining a denormalized "world" view. A view that joins a large number of database tables that is used for a wide variety of queries.
	Performance issues can occur for some queries that use the view for some WHERE conditions while other WHERE conditions work well.
*/

--dati utente joinati
CREATE OR REPLACE VIEW v_profilo_utente AS
SELECT
	id_utente,
	
	--anagrafici
	nome,
	cognome,
	dataN,
	
	id_citta,
	nome_citta,
	
	--dati sito
	nickname,
	passwd,
	mail,
	src AS foto_profilo,
	usr.descrizione

FROM Profilo_utente usr
JOIN Citta USING(id_citta)
JOIN Immagine ON foto_profilo = id_immagine;



--versione joinata della raccolta_immagini/galleria
CREATE OR REPLACE VIEW v_raccolta_immagini AS
WITH grouped_imgs AS (
	SELECT id_raccolta, ARRAY_AGG(src) AS immagini
	FROM Immagine
	JOIN Immagine_appartiene_raccolta USING(id_immagine)
	GROUP BY id_raccolta
)
SELECT 
	id_raccolta,
	nome_raccolta,
	descrizione,
	immagini

FROM Raccolta_immagini 
JOIN grouped_imgs USING(id_raccolta)
;



--LOOKUP joinati

CREATE OR REPLACE VIEW v_strumenti_musicali_per_artista AS
SELECT
	id_artista,
	COALESCE(
		(
			SELECT ARRAY_AGG(nome_strumento)
			FROM strumento_musicale
			JOIN strumento_artista_lookup USING(id_strumento)
			WHERE pa.id_artista = id_artista
		),
		ARRAY[]::varchar[]
	) AS strumenti_musicali
FROM profilo_artista pa
;



CREATE OR REPLACE VIEW v_generi_musicali_per_artista AS
SELECT
	id_artista,
	COALESCE(
		(
			SELECT ARRAY_AGG(nome_genere)
			FROM genere_musicale
			JOIN genere_artista_lookup USING(id_genere)
			WHERE pa.id_artista = id_artista
		),
		ARRAY[]::varchar[]
	) AS generi_musicali
FROM profilo_artista pa
;

CREATE OR REPLACE VIEW v_servizi_musicali_per_artista AS
SELECT
	id_artista,
	COALESCE(
		(
			SELECT ARRAY_AGG(nome_servizio)
			FROM servizio_musicale
			JOIN servizio_artista_lookup USING(id_servizio)
			WHERE pa.id_artista = id_artista
		),
		ARRAY[]::varchar[]
	) AS servizi_forniti
FROM profilo_artista pa
;

CREATE OR REPLACE VIEW v_generi_musicali_per_band AS
SELECT
	id_band,
	COALESCE(
		(
			SELECT ARRAY_AGG(nome_genere)
			FROM genere_musicale
			JOIN genere_band_lookup USING(id_genere)
			WHERE pb.id_band = id_band
		),
		ARRAY[]::varchar[]
	) AS generi_musicali
FROM profilo_band pb
;

CREATE OR REPLACE VIEW v_servizi_musicali_per_band AS
SELECT
	id_band,
	COALESCE(
		(
			SELECT ARRAY_AGG(nome_servizio)
			FROM servizio_musicale
			JOIN servizio_band_lookup USING(id_servizio)
			WHERE pb.id_band = id_band
		),
		ARRAY[]::varchar[]
	) AS servizi_forniti
FROM profilo_band pb
;

--fine lookup



CREATE OR REPLACE VIEW v_profilo_artista AS
WITH valutazioni_artista AS (
	SELECT id_oggetto AS id_artista, ROUND(AVG(valutazione)) AS valutazione_media
	FROM Recensione_artista
	GROUP BY id_oggetto
)
SELECT
	pa.id_artista,
	
	--restituisce il nomedarte, nome e cognome altrimenti
	COALESCE (
		nomedarte, 
		nome || ' ' || cognome,
		nickname
	) AS nome,
	
	pa.descrizione,
	LOWER(range_prezzo) AS min_prezzo,
	UPPER(range_prezzo) AS max_prezzo,
	
	valutazione_media,
	
	--immagini
	fp.src AS foto_profilo,
	immagini AS foto_galleria,
	
	--lookups
	
	generi_musicali,
	strumenti_musicali,
	servizi_forniti,
	
	id_citta,
	nome_citta

FROM Profilo_artista pa
JOIN v_profilo_utente ON id_utente = id_artista
JOIN Immagine fp ON pa.foto_profilo = id_immagine
JOIN v_raccolta_immagini ON galleria_artista = id_raccolta

JOIN v_strumenti_musicali_per_artista USING (id_artista)
JOIN v_generi_musicali_per_artista USING (id_artista)
JOIN v_servizi_musicali_per_artista USING (id_artista)

LEFT JOIN valutazioni_artista USING(id_artista)		--una valutazione media null indica che non ha ancora avuto recensioni
;


CREATE OR REPLACE VIEW v_profilo_band AS
WITH valutazioni_band AS (
	SELECT id_oggetto AS id_band, ROUND(AVG(valutazione)) AS valutazione_media
	FROM Recensione_band
	GROUP BY id_oggetto
)
SELECT
	id_band,
	nome_band,
	LOWER(range_prezzo) AS min_prezzo,
	UPPER(range_prezzo) AS max_prezzo,
	
	valutazione_media,
	
	fp.src AS foto_profilo,
	id_citta AS id_sede,
	nome_citta AS sede,
	
	generi_musicali,
	servizi_forniti

FROM Profilo_band
JOIN Immagine fp ON foto_profilo = id_immagine
JOIN Citta ON id_sede = id_citta
JOIN v_generi_musicali_per_band USING (id_band)
JOIN v_servizi_musicali_per_band USING (id_band)
LEFT JOIN valutazioni_band USING(id_band)		--una valutazione media null indica che non ha ancora avuto recensioni
;


CREATE OR REPLACE VIEW v_profilo_locale AS
WITH valutazioni_locale AS (
	SELECT id_oggetto AS id_locale, ROUND(AVG(valutazione)) AS valutazione_media
	FROM Recensione_locale
	GROUP BY id_oggetto
)
SELECT
	id_locale,
	nome_locale,
	pl.descrizione AS descrizione_locale,
	valutazione_media,
	
	titolare AS id_titolare,
	(SELECT nome || ' ' || cognome FROM Profilo_utente WHERE id_utente = titolare) AS titolare,
	
	pl.id_citta,
	nome_citta,
	indirizzo,
	
	fp.src AS foto_profilo,
	imgs.immagini AS foto_galleria

FROM Profilo_locale pl
JOIN Profilo_utente ON titolare = id_utente
JOIN Immagine fp ON pl.foto_profilo = id_immagine
JOIN v_raccolta_immagini imgs ON galleria_locale = id_raccolta
JOIN Citta ON pl.id_citta = Citta.id_citta
LEFT JOIN valutazioni_locale USING(id_locale)		--una valutazione media null indica che non ha ancora avuto recensioni
;


CREATE OR REPLACE VIEW v_ingaggio AS

SELECT
	id_ingaggio,
	src AS immagine,
	titolo,
	i.descrizione,
	data_ingaggio,
	ora_inizio,
	ora_fine,
	compenso_indicativo,
	i.indirizzo,

	datore AS id_datore,
	nickname AS nick_datore,

	(SELECT nome_locale
	FROM Profilo_locale
	WHERE id_locale = id_luogo) AS nome_locale,

	(SELECT id_citta
	FROM Profilo_locale
	WHERE id_locale = id_luogo) AS id_citta

FROM Ingaggio i
JOIN Profilo_utente ON datore = id_utente
JOIN Immagine ON i.immagine = id_immagine
;








	
	





