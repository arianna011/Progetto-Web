/*
Lo scopo di queste view è nascondere la struttura del database alle applicazioni php, in modo che possano essere modificate indipendentemente

cose da evitare durante definizione di view:
- Defining many layers of views so that your final queries look deceptively simple:
	Problems arise when you try to enhance or troubleshoot queries that use the views, for example by examining the execution plan. The query's execution plan tends to be complicated and it is difficult to understand and how to improve it.

-Defining a denormalized "world" view. A view that joins a large number of database tables that is used for a wide variety of queries.
	Performance issues can occur for some queries that use the view for some WHERE conditions while other WHERE conditions work well.
*/

--dati utente joinati
CREATE OR REPLACE VIEW v_dati_utente AS
SELECT
	id_utente,
	
	--anagrafici
	nome,
	cognome,
	dataN,
	--usr.id_citta,
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
SELECT 
	id_raccolta,
	nome_raccolta,
	descrizione,
	immagini

FROM Raccolta_immagini 
JOIN(
	SELECT id_raccolta, ARRAY_AGG(src) AS immagini
	FROM Immagine
	JOIN Immagine_appartiene_raccolta USING(id_immagine)
	GROUP BY id_raccolta
	ORDER BY id_raccolta
) AS grouped USING(id_raccolta)
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
SELECT
	pa.id_artista,
	
	--restituisce il nomedarte, nome e cognome altrimenti
	COALESCE (
		nomedarte, 
		(SELECT nome || ' ' || cognome FROM Profilo_utente WHERE id_utente = id_artista)
		--(SELECT nickname FROM Profilo_utente WHERE id_utente = id_artista)
	) AS nome,
	
	pa.descrizione,
	LOWER(range_prezzo) AS min_prezzo,
	UPPER(range_prezzo) AS max_prezzo,
	
	--immagini
	fp.src AS foto_profilo,
	immagini AS foto_galleria,
	
	--lookups
	
	generi_musicali,
	strumenti_musicali,
	servizi_forniti

FROM Profilo_artista pa
JOIN Immagine fp ON foto_profilo = id_immagine
JOIN v_raccolta_immagini ON galleria_artista = id_raccolta
JOIN v_strumenti_musicali_per_artista USING (id_artista)
JOIN v_generi_musicali_per_artista USING (id_artista)
JOIN v_servizi_musicali_per_artista USING (id_artista)
;


CREATE OR REPLACE VIEW v_profilo_band AS
SELECT
	id_band,
	nome_band,
	LOWER(range_prezzo) AS min_prezzo,
	UPPER(range_prezzo) AS max_prezzo,
	
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
;








	
	





