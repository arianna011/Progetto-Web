ALTER TABLE ingaggio
add indirizzio	 VARCHAR(64),
add ora_inizio TIME,	 
add ora_fine TIME

ALTER TABLE Profilo_band
add descrizione		VARCHAR(1024) --nullable


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
	servizi_forniti,
	descrizione

FROM Profilo_band
JOIN Immagine fp ON foto_profilo = id_immagine
JOIN Citta ON id_sede = id_citta
JOIN v_generi_musicali_per_band USING (id_band)
JOIN v_servizi_musicali_per_band USING (id_band)
LEFT JOIN valutazioni_band USING(id_band)		--una valutazione media null indica che non ha ancora avuto recensioni
;
