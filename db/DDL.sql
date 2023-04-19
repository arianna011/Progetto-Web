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
	nome			VARCHAR(20),
	descrizione		VARCHAR(100)	
);

--stessa immagine puo appartenere a galleria una volta sola? (andrebbe caricata 2 volte) (evitare casini)
CREATE TABLE IF NOT EXISTS Immagine_appartiene_raccolta(
	PRIMARY KEY(id_immagine, id_raccolta),
	id_immagine		INT
					REFERENCES Immagine(id_immagine),
	id_raccolta		INT
					REFERENCES Raccolta_immagini(id_raccolta)
);


--UTILITA' GENERALI (UTENTE)
CREATE TABLE IF NOT EXISTS Citta
(
	PRIMARY KEY (id_citta),
    id_citta	INT 		GENERATED ALWAYS AS IDENTITY,
    nome		VARCHAR(40)	NOT NULL
);

CREATE TABLE IF NOT EXISTS Utente(
	PRIMARY KEY (id_utente),
	id_utente		INT			GENERATED ALWAYS AS IDENTITY,
	nome			VARCHAR(50)	NOT NULL,
	cognome			VARCHAR(50)	NOT NULL,
	dataN			DATE		NOT NULL,
	nickname		VARCHAR(50) NOT NULL,
	passwd			VARCHAR(30)	NOT NULL,
	mail			VARCHAR(70)	NOT NULL
					CONSTRAINT validazione_mail
					CHECK(mail LIKE '%_@%_.__%'),
	id_citta		INT			--nullable
					REFERENCES Citta(id_citta),	--spostato da 'Artista' a qui (potrebbe essere utile sapere la citta anche di utenti non artisti)
	foto_profilo	INT			--nullable
					REFERENCES Immagine(id_immagine),
	galleria_utente	INT			--nullable
					REFERENCES Raccolta_immagini(id_raccolta)
);

--ROBA ARTISTI
CREATE TABLE IF NOT EXISTS Profilo_artista(
	PRIMARY KEY (id_artista),
	id_artista			INT
						REFERENCES Utente(id_utente)	--NB: la chiave del profilo artista è la stessa del profilo utente; card(1,1)
						ON UPDATE CASCADE
						ON DELETE CASCADE,
	nomedarte			VARCHAR(20),
	galleria_artista	INT				--nullable
						REFERENCES Raccolta_immagini(id_raccolta)	
	--link social? video e immagini esclusive del profilo artista? per ora non contiene molto ma più avanti verrà "rimpolpata"
);

CREATE TABLE IF NOT EXISTS Genere_musicale(
	PRIMARY KEY(id_genere),
	id_genere	SMALLINT		GENERATED ALWAYS AS IDENTITY,
	nome_genere	VARCHAR(30)		UNIQUE NOT NULL
);

INSERT INTO Genere_musicale (nome_genere) VALUES
('Jazz'), ('Rock'),
('Pop'), ('Blues'), ('Rap'), ('Country'), ('Indie'),
('R&B'), ('Metal'), ('Musica classica'), ('Ballad'),
('Folk'), ('Ambient'), ('Elettronica'), ('Irlandese');

CREATE TABLE IF NOT EXISTS Strumento_musicale(
	PRIMARY KEY(id_strumento),
	id_strumento	SMALLINT		GENERATED ALWAYS AS IDENTITY,
	nome_strumento	VARCHAR(30)		UNIQUE NOT NULL
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
	nome_servizio	VARCHAR(30)		UNIQUE NOT NULL
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
							ON DELETE CASCADE,
	id_genere		INT		REFERENCES Genere_musicale(id_genere)
							ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Strumento_artista_lookup
(
	PRIMARY KEY(id_artista, id_strumento),
	id_artista		INT		REFERENCES Profilo_artista(id_artista)
							ON DELETE CASCADE,
	id_strumento	INT		REFERENCES Strumento_musicale(id_strumento)
							ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Servizio_artista_lookup
(
	PRIMARY KEY(id_artista, id_servizio),
	id_artista		INT		REFERENCES Profilo_artista(id_artista)
							ON DELETE CASCADE,
	id_servizio		INT		REFERENCES Servizio_musicale(id_servizio)
							ON DELETE CASCADE
);

--ROBA BAND
	
CREATE TABLE IF NOT EXISTS Profilo_band
(
	PRIMARY KEY(id_band),
	id_band		INT				GENERATED ALWAYS AS IDENTITY,
	nome_band	VARCHAR(20)		NOT NULL,
	id_sede		INT				--nullable
				REFERENCES Citta(id_citta)	--sede principale della band
);

--necessaria per rappresentare anche membri senza profilo
CREATE TABLE IF NOT EXISTS Membro_band
(
	PRIMARY KEY(id_membro),
	id_membro	INT		GENERATED ALWAYS AS IDENTITY,
	nome		VARCHAR(50),							--NB:trigger, se profilo è not null, nome e cognome sono uguali a quelli del profilo (in questo caso la ridondanza è opportuna e la consistenza è facile da implementare)
	cognome		VARCHAR(50),
	nomedarte	VARCHAR(50),
	profilo		INT			--nullable (per membri non registrati)
				REFERENCES Profilo_artista(id_artista)
				ON DELETE SET NULL
);

--garantisce si che il collegamento fra il membro di una band e un profilo artista avvenga correttamente, nel caso sia presente
CREATE OR REPLACE FUNCTION set_membro_registrato() RETURNS TRIGGER AS $$
DECLARE nomedarte_profilo VARCHAR;
BEGIN
	
	IF NEW.profilo IS NOT NULL THEN 
	
		--se ci sono gia nome e/o cognome do errore
		IF NEW.nome IS NOT NULL OR NEW.cognome IS NOT NULL THEN 
			RAISE EXCEPTION
				'Non è permesso specificare un profilo e un nome/cognome contemporaneamente: questi dati vengono reperiti direttamente dal profilo onde evitare incoerenze (id profilo: %, ''% %'')',
				NEW.profilo, NEW.nome, NEW.cognome;
		END IF;
		
		--reperisco i dati del membro direttamente dal profilo indicato
		SELECT nome, cognome, nomedarte
		INTO NEW.nome, NEW.cognome, nomedarte_profilo
		FROM Utente JOIN Profilo_artista ON id_utente = id_artista
		WHERE id_artista = NEW.profilo;
		
		--se manca il nomedarte, prova a prenderlo dal profilo artista (forse non desiderabile?)
		IF NEW.nomedarte IS NULL THEN 
			NEW.nomedarte := nomedarte_profilo;
		END IF;
	END IF;
	
	RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER TR_set_membro_registrato
BEFORE INSERT ON Membro_band
FOR EACH ROW
EXECUTE FUNCTION set_membro_registrato();


	
CREATE TABLE IF NOT EXISTS Partecipazione_band
(
	PRIMARY KEY(id_membro, id_band, id_ruolo),
	id_membro		INT		REFERENCES Membro_band(id_membro)
							ON DELETE CASCADE,
	id_band			INT		REFERENCES Profilo_band(id_band)
							ON DELETE CASCADE,
	id_ruolo		INT		REFERENCES Strumento_musicale(id_strumento)
							ON DELETE CASCADE
);
	
CREATE TABLE IF NOT EXISTS Servizio_band_lookup
(
	PRIMARY KEY(id_band, id_servizio),
	id_band		INT		REFERENCES Profilo_band(id_band)
						ON DELETE CASCADE,
	id_servizio	INT		REFERENCES Servizio_musicale(id_servizio)
						ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Genere_band_lookup
(
	PRIMARY KEY(id_band, id_genere),
	id_band		INT		REFERENCES Profilo_band(id_band)
						ON DELETE CASCADE,
	id_genere	INT		REFERENCES Genere_musicale(id_genere)
						ON DELETE CASCADE
);
	
--ROBA LOCALI/HOST

CREATE TABLE IF NOT EXISTS Profilo_locale
(
	PRIMARY KEY(id_locale),
	id_locale		INT				GENERATED ALWAYS AS IDENTITY,	--chiave generata, perchè ad un profilo utente possono essere associati più locali (capitalisti dello show business >:( ))
	
	nome_locale		VARCHAR(50)		NOT NULL,
	titolare		INT				NOT NULL
					REFERENCES Utente(id_utente)
					ON DELETE CASCADE,
	
	id_citta		INT				NOT NULL
					REFERENCES Citta(id_citta)
					ON DELETE NO ACTION,
	indirizzo		VARCHAR(50),	--nullable
	galleria_locale	INT				--nullable
					REFERENCES Raccolta_immagini(id_raccolta)
);
	
CREATE TABLE IF NOT EXISTS Evento
(
	PRIMARY KEY(id_evento),
	id_evento		INT				GENERATED ALWAYS AS IDENTITY,
	
	titolo			VARCHAR(50)		NOT NULL,
	descrizione		VARCHAR(200)	NOT NULL,
	data_evento		DATE			NOT NULL,
	--ora evento?
	id_luogo		INT				NOT NULL
					REFERENCES Profilo_locale(id_locale)
					ON DELETE NO ACTION,
	immagine		INT				--nullable
					REFERENCES Immagine(id_immagine)
);

--RECENSIONI
CREATE TABLE IF NOT EXISTS Recensione_artista(
	PRIMARY KEY (id_utente, oggetto),
	valutazione		INT		NOT NULL				--votazione in decimi
					CONSTRAINT rating_range_artista
					CHECK(valutazione < 10 AND valutazione > 0),
	
	testo			VARCHAR(200)	NOT NULL,
	data_recensione	DATE	NOT NULL
					DEFAULT NOW(),
	
	id_utente		INT		NOT NULL
					REFERENCES Utente(id_utente)
					ON UPDATE CASCADE
					ON DELETE SET NULL,
	
	oggetto			INT		NOT NULL
					REFERENCES Profilo_artista(id_artista)
					ON UPDATE CASCADE
					ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Recensione_band(
	PRIMARY KEY (id_utente, oggetto),
	valutazione		INT		NOT NULL				--votazione in decimi
					CONSTRAINT rating_range_band
					CHECK(valutazione < 10 AND valutazione > 0),
	
	testo			VARCHAR(200)	NOT NULL,
	data_recensione	DATE	NOT NULL
					DEFAULT NOW(),
	
	id_utente		INT		NOT NULL
					REFERENCES Utente(id_utente)
					ON UPDATE CASCADE
					ON DELETE SET NULL,
		
	oggetto			INT		NOT NULL
					REFERENCES Profilo_band(id_band)
					ON UPDATE CASCADE
					ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS Recensione_locale(
	PRIMARY KEY (id_utente, oggetto),
	valutazione		INT		NOT NULL				--votazione in decimi
					CONSTRAINT rating_range_locale
					CHECK(valutazione < 10 AND valutazione > 0),
	
	testo			VARCHAR(200)	NOT NULL,
	data_recensione	DATE	NOT NULL
					DEFAULT NOW(),
	
	id_utente		INT		NOT NULL
					REFERENCES Utente(id_utente)
					ON UPDATE CASCADE
					ON DELETE SET NULL,
	
	oggetto			INT		NOT NULL
					REFERENCES Profilo_locale(id_locale)
					ON UPDATE CASCADE
					ON DELETE SET NULL
);


	
	
	
	

