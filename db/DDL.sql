-- Database: NotaMi

--DROP DATABASE IF EXISTS "NotaMi";

/*CREATE DATABASE "NotaMi"
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Italian_Italy.1252'
    LC_CTYPE = 'Italian_Italy.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

COMMENT ON DATABASE "NotaMi"
    IS 'progetto LTW';
*/

--GESTIONE IMMAGINI
CREATE TABLE IF NOT EXISTS Immagine(
	PRIMARY KEY(id_immagine),
	id_immagine		INT		GENERATED ALWAYS AS IDENTITY,
	src				VARCHAR	NOT NULL
);

--ho scelto di creare un'entità raccolta per facilitare gestione di gruppi di immagini distinti
CREATE TABLE IF NOT EXISTS Raccolta_immagini(
	PRIMARY KEY(id_raccolta),
	id_raccolta 	INT				GENERATED ALWAYS AS IDENTITY,
	nome_raccolta	VARCHAR(64),
	descrizione		VARCHAR(256)	
);

--stessa immagine puo appartenere a galleria una volta sola? (andrebbe caricata 2 volte) (evitare casini)
CREATE TABLE IF NOT EXISTS Immagine_appartiene_raccolta(
	PRIMARY KEY(id_immagine, id_raccolta),
	id_immagine		INT
					REFERENCES Immagine(id_immagine)
					ON DELETE CASCADE,
	id_raccolta		INT
					REFERENCES Raccolta_immagini(id_raccolta)
					ON DELETE CASCADE
);


--UTILITA' GENERALI (UTENTE)
CREATE TABLE IF NOT EXISTS Citta
(
	PRIMARY KEY (id_citta),
    id_citta	INT 		GENERATED ALWAYS AS IDENTITY,
    nome_citta	VARCHAR(64)	UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS Profilo_utente(
	PRIMARY KEY (id_utente),
	id_utente		INT			GENERATED ALWAYS AS IDENTITY,
	univoco			VARCHAR(70), --nullable --usata per tenere traccia delle sessioni (cookie)
	
	nome			VARCHAR(64)	NOT NULL,
	cognome			VARCHAR(64)	NOT NULL,
	dataN			DATE		NOT NULL,
	nickname		VARCHAR(64) UNIQUE NOT NULL,
	passwd			VARCHAR(32) NOT NULL,
	mail			VARCHAR(64)	--nullable
					CONSTRAINT validazione_mail
					CHECK(mail LIKE '%_@%_.__%'),
	id_citta		INT			--nullable
					REFERENCES Citta(id_citta)	--spostato da 'Artista' a qui (potrebbe essere utile sapere la citta anche di utenti non artisti)
					ON DELETE SET NULL
					ON UPDATE CASCADE,
	foto_profilo	INT			--nullable
					REFERENCES Immagine(id_immagine)
					ON DELETE SET NULL
					ON UPDATE CASCADE,
	
	/*galleria_utente	INT			--nullable
					REFERENCES Raccolta_immagini(id_raccolta),*/
	
	descrizione		VARCHAR(1024) --nullable
);

--ROBA ARTISTI
CREATE TABLE IF NOT EXISTS Profilo_artista(
	PRIMARY KEY (id_artista),
	id_artista			INT
						REFERENCES Profilo_utente(id_utente)	--NB: la chiave del profilo artista è la stessa del profilo utente; cardinalità(1,1)
						ON UPDATE CASCADE
						ON DELETE CASCADE,
	nomedarte			VARCHAR(32),
	
	--idea: se assente potrebbe essere sostituita per default dall'immagine del profilo principale
	foto_profilo		INT			--nullable
						REFERENCES Immagine(id_immagine)
						ON DELETE SET NULL
						ON UPDATE CASCADE,
		
	galleria_artista	INT			--nullable
						REFERENCES Raccolta_immagini(id_raccolta)
						ON DELETE SET NULL
						ON UPDATE CASCADE,
	
	descrizione			VARCHAR(1024), --nullable
	
	range_prezzo		int4range	--nullable
	--link social? 
);

--alla creazione del profilo artista, se la foto non è presente, viene impostata quella del profilo utente per default
CREATE OR REPLACE FUNCTION set_default_profpic_artista() RETURNS TRIGGER AS $$
BEGIN
	IF NEW.foto_profilo IS NULL THEN
		SELECT foto_profilo
		INTO NEW.foto_profilo
		FROM Profilo_utente
		WHERE id_utente = NEW.id_artista;
	END IF;
	RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER TR_set_default_profpic_artista
BEFORE INSERT ON Profilo_artista		--Rischio confutato: il trigger BEFORE non da problemi nell'evenienza in cui profilo utente e profilo artista siano creati nella stessa query (per essere sicuro di trovare il profilo utente da cui prendere l'immagine, facendo la select)
FOR EACH ROW
EXECUTE FUNCTION set_default_profpic_artista();

CREATE TABLE IF NOT EXISTS Genere_musicale(
	PRIMARY KEY(id_genere),
	id_genere	SMALLINT		GENERATED ALWAYS AS IDENTITY,
	nome_genere	VARCHAR(32)		UNIQUE NOT NULL
);

INSERT INTO Genere_musicale (nome_genere) VALUES
('Jazz'), ('Rock'),
('Pop'), ('Blues'), ('Rap'), ('Country'), ('Indie'),
('R&B'), ('Metal'), ('Musica classica'), ('Ballad'),
('Folk'), ('Ambient'), ('Elettronica'), ('Irlandese'),

('Dance & EDM'), ('Etnica'), ('Italiana'), ('Latina')
;

CREATE TABLE IF NOT EXISTS Strumento_musicale(
	PRIMARY KEY(id_strumento),
	id_strumento	SMALLINT		GENERATED ALWAYS AS IDENTITY,
	nome_strumento	VARCHAR(32)		UNIQUE NOT NULL
);

--forse andrebbe rinominato "competenza musicale"
INSERT INTO Strumento_musicale (nome_strumento) VALUES
('Tromba'), ('Trombone'), ('Corno francese'), ('Tuba'), ('Sassofono'),
('Flauto'), 
('Piano'), ('Xylofono'), ('Organo'), ('Fisarmonica'),
('Chitarra'), ('Chiatarra elettrica'), ('Basso'),
('Violino'), ('Viola'), ('Violoncello'), ('Contrabbasso'), ('Arpa'),
('Percussioni'), ('Batteria'), ('Triangolo'),
('Cantante'), ('Basso (registro vocale)'), ('Baritono'), ('Tenore'), ('Contralto'), ('Mezzosoprano'), ('Soprano'),
('DJ'), ('Mixing');

CREATE TABLE IF NOT EXISTS Servizio_musicale(
	PRIMARY KEY(id_servizio),
	id_servizio		SMALLINT		GENERATED ALWAYS AS IDENTITY,
	nome_servizio	VARCHAR(32)		UNIQUE NOT NULL
);

INSERT INTO Servizio_musicale(nome_servizio) VALUES
('Eventi privati'),
('Concerti'), 
('Matrimoni'), 
('Lezioni private'),
('Accordatura strumento')
;

CREATE TABLE IF NOT EXISTS Genere_artista_lookup
(
	PRIMARY KEY(id_artista, id_genere),
	id_artista		INT		REFERENCES Profilo_artista(id_artista)
							ON DELETE CASCADE
							ON UPDATE CASCADE,
	id_genere		INT		REFERENCES Genere_musicale(id_genere)
							ON DELETE CASCADE
							ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Strumento_artista_lookup
(
	PRIMARY KEY(id_artista, id_strumento),
	id_artista		INT		REFERENCES Profilo_artista(id_artista)
							ON DELETE CASCADE
							ON UPDATE CASCADE,
	id_strumento	INT		REFERENCES Strumento_musicale(id_strumento)
							ON DELETE CASCADE
							ON UPDATE CASCADE
	
);

CREATE TABLE IF NOT EXISTS Servizio_artista_lookup
(
	PRIMARY KEY(id_artista, id_servizio),
	id_artista		INT		REFERENCES Profilo_artista(id_artista)
							ON DELETE CASCADE
							ON UPDATE CASCADE,
	id_servizio		INT		REFERENCES Servizio_musicale(id_servizio)
							ON DELETE CASCADE
							ON UPDATE CASCADE
);

--ROBA BAND
	
CREATE TABLE IF NOT EXISTS Profilo_band
(
	PRIMARY KEY(id_band),
	id_band			INT				GENERATED ALWAYS AS IDENTITY,
	nome_band		VARCHAR(64)		NOT NULL,
	range_prezzo	int4range,	--nullable
	foto_profilo	INT			--nullable
					REFERENCES Immagine(id_immagine)
					ON DELETE SET NULL
					ON UPDATE CASCADE,
	id_sede			INT				--nullable
					REFERENCES Citta(id_citta)	--sede principale della band
					ON DELETE SET NULL
					ON UPDATE CASCADE,
 	descrizione		VARCHAR(1024) --nullable
);

--necessaria per rappresentare anche membri senza profilo
CREATE TABLE IF NOT EXISTS Membro_band
(
	PRIMARY KEY(id_membro),
	id_membro	INT		GENERATED ALWAYS AS IDENTITY,
	nome		VARCHAR(64),							--NB:trigger, se profilo è not null, nome e cognome sono uguali a quelli del profilo (in questo caso la ridondanza è opportuna e la consistenza è facile da implementare)
	cognome		VARCHAR(64),
	nomedarte	VARCHAR(64),
	profilo		INT			--nullable (per membri non registrati)
				REFERENCES Profilo_artista(id_artista)
				ON DELETE SET NULL
				ON UPDATE CASCADE
);

--garantisce si che il collegamento fra il membro di una band e un profilo artista avvenga correttamente, nel caso ques'ultimo sia presente
CREATE OR REPLACE FUNCTION set_default_membro_registrato() RETURNS TRIGGER AS $$
DECLARE nomedarte_profilo VARCHAR;
BEGIN
	
	IF NEW.profilo IS NOT NULL THEN 
	
		--se ci sono gia nome e/o cognome do errore
		IF NEW.nome IS NOT NULL OR NEW.cognome IS NOT NULL THEN 
			RAISE EXCEPTION
				'Non è permesso specificare nome/cognome per un membro già registrato (id profilo già specificato); tali dati vengono reperiti direttamente dal profilo onde evitare incoerenze (id profilo: %, ''% %'')',
				NEW.profilo, NEW.nome, NEW.cognome;
		END IF;
		
		--reperisco i dati del membro direttamente dal profilo indicato
		SELECT nome, cognome, nomedarte
		INTO NEW.nome, NEW.cognome, nomedarte_profilo
		FROM Profilo_utente JOIN Profilo_artista ON id_utente = id_artista
		WHERE id_artista = NEW.profilo;
		
		--se manca il nomedarte, prova a prenderlo dal profilo artista (forse non desiderabile?)
		IF NEW.nomedarte IS NULL THEN 
			NEW.nomedarte := nomedarte_profilo;
		END IF;
	END IF;
	
	RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER TR_set_default_membro_registrato
BEFORE INSERT ON Membro_band
FOR EACH ROW
EXECUTE FUNCTION set_default_membro_registrato();


	
CREATE TABLE IF NOT EXISTS Partecipazione_band
(
	PRIMARY KEY(id_membro, id_band, id_ruolo),
	id_membro		INT		REFERENCES Membro_band(id_membro)
							ON DELETE CASCADE
							ON UPDATE CASCADE,
	id_band			INT		REFERENCES Profilo_band(id_band)
							ON DELETE CASCADE
							ON UPDATE CASCADE,
	id_ruolo		INT		REFERENCES Strumento_musicale(id_strumento)
							ON DELETE CASCADE
							ON UPDATE CASCADE
);
	
CREATE TABLE IF NOT EXISTS Servizio_band_lookup
(
	PRIMARY KEY(id_band, id_servizio),
	id_band		INT		REFERENCES Profilo_band(id_band)
						ON DELETE CASCADE
						ON UPDATE CASCADE,
	id_servizio	INT		REFERENCES Servizio_musicale(id_servizio)
						ON DELETE CASCADE
						ON UPDATE CASCADE
);


CREATE TABLE IF NOT EXISTS Genere_band_lookup
(
	PRIMARY KEY(id_band, id_genere),
	id_band		INT		REFERENCES Profilo_band(id_band)
						ON DELETE CASCADE
						ON UPDATE CASCADE,
	id_genere	INT		REFERENCES Genere_musicale(id_genere)
						ON DELETE CASCADE
						ON UPDATE CASCADE
);
	
--ROBA LOCALI/HOST

CREATE TABLE IF NOT EXISTS Profilo_locale
(
	PRIMARY KEY(id_locale),
	id_locale		INT				GENERATED ALWAYS AS IDENTITY,	--chiave generata, perchè ad un profilo utente possono essere associati più locali (capitalisti dello show business >:( ))
	
	nome_locale		VARCHAR(64)		NOT NULL,
	titolare		INT				NOT NULL
					REFERENCES Profilo_utente(id_utente)
					ON DELETE CASCADE
					ON UPDATE CASCADE,
	
	id_citta		INT				NOT NULL
					REFERENCES Citta(id_citta)
					ON DELETE NO ACTION
					ON UPDATE CASCADE,
	indirizzo		VARCHAR(64),	--nullable
	
	foto_profilo	INT			--nullable
					REFERENCES Immagine(id_immagine)
					ON DELETE SET NULL
					ON UPDATE CASCADE,
	galleria_locale	INT				--nullable
					REFERENCES Raccolta_immagini(id_raccolta)
					ON DELETE SET NULL
					ON UPDATE CASCADE,
	descrizione		VARCHAR(512) --nullable
);
	
CREATE TABLE IF NOT EXISTS Ingaggio
(
	PRIMARY KEY(id_ingaggio),
	id_ingaggio				INT				GENERATED ALWAYS AS IDENTITY,
	
	datore					INT				NOT NULL
							REFERENCES Profilo_utente(id_utente)
							ON DELETE CASCADE
							ON UPDATE CASCADE,
	
	titolo					VARCHAR(64)		NOT NULL,
	descrizione				VARCHAR(512)	NOT NULL,
	data_ingaggio			DATE			NOT NULL,
	ora_inizio 				TIME,			--nullable(aggiunto dopo)
	ora_fine 				TIME,			--nullable(aggiunto dopo)
	
	indirizzo	 			VARCHAR(64),
	id_luogo				INT				--nullable
							REFERENCES Profilo_locale(id_locale)
							ON DELETE NO ACTION
							ON UPDATE CASCADE,
	immagine				INT				--nullable
							REFERENCES Immagine(id_immagine)
							ON DELETE SET NULL
							ON UPDATE CASCADE,

	compenso_indicativo		NUMERIC(10,2)	--nullable
);

--RECENSIONI
CREATE TABLE IF NOT EXISTS Recensione_artista(
	PRIMARY KEY (id_utente, id_oggetto),
	valutazione		SMALLINT		NOT NULL				--votazione in decimi
					CONSTRAINT rating_range_artista
					CHECK(valutazione BETWEEN 0 AND 10),
	
	testo			VARCHAR(512)	NOT NULL,
	data_recensione	DATE			NOT NULL
					DEFAULT NOW(),
	
	id_utente		INT		NOT NULL
					REFERENCES Profilo_utente(id_utente)
					ON UPDATE CASCADE
					ON DELETE SET NULL,
	
	id_oggetto			INT		NOT NULL
					REFERENCES Profilo_artista(id_artista)
					ON UPDATE CASCADE
					ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Recensione_band(
	PRIMARY KEY (id_utente, id_oggetto),
	valutazione		INT		NOT NULL				--votazione in decimi
					CONSTRAINT rating_range_band
					CHECK(valutazione BETWEEN 0 AND 10),
	
	testo			VARCHAR(512)	NOT NULL,
	data_recensione	DATE			NOT NULL
					DEFAULT NOW(),
	
	id_utente		INT		NOT NULL
					REFERENCES Profilo_utente(id_utente)
					ON UPDATE CASCADE
					ON DELETE SET NULL,
		
	id_oggetto			INT		NOT NULL
					REFERENCES Profilo_band(id_band)
					ON UPDATE CASCADE
					ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Recensione_locale(
	PRIMARY KEY (id_utente, id_oggetto),
	valutazione		INT		NOT NULL				--votazione in decimi
					CONSTRAINT rating_range_locale
					CHECK(valutazione BETWEEN 0 AND 10),
	
	testo			VARCHAR(512)	NOT NULL,
	data_recensione	DATE	NOT NULL
					DEFAULT NOW(),
	
	id_utente		INT		NOT NULL
					REFERENCES Profilo_utente(id_utente)
					ON UPDATE CASCADE
					ON DELETE SET NULL,
	
	id_oggetto			INT		NOT NULL
					REFERENCES Profilo_locale(id_locale)
					ON UPDATE CASCADE
					ON DELETE SET NULL
);


	
	
	
	

