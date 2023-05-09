insert into immagine(src) values('band-1.jpg');
insert into Profilo_band(nome_band, range_prezzo, foto_profilo, id_sede, descrizione) values ('The Echoes', '[100,500]',
'1002','1','The Echoes è una band indie rock che offre un mix coinvolgente di melodie orecchiabili, riff di chitarra potenti e testi poetici. Il loro sound unico incorpora elementi di rock classico e alternativo, con un tocco moderno e fresco. The Echoes è una band che ha qualcosa da dire e lo fa con stile e grinta'
);
insert into Genere_band_lookup (id_band,id_genere) values (24,2);
insert into Genere_band_lookup (id_band,id_genere) values (24,7);

insert into immagine(src) values('band-2.jpg');
insert into Profilo_band(nome_band, range_prezzo, foto_profilo, id_sede, descrizione) values ('Cityscape', '[80,450]',
'1003','44','Siamo una band originaria di Milano. Ci piace farci conoscere al pubblico esibendoci su palchi in tutta Italia e partecipando a diversi tipi di eventi, anche privati. '
);
insert into Genere_band_lookup (id_band,id_genere) values (25,3);
insert into Genere_band_lookup (id_band,id_genere) values (25,11);
insert into servizio_band_lookup (id_band,id_servizio) values(25,1);
insert into servizio_band_lookup (id_band,id_servizio) values(25,2);


insert into immagine(src) values ('evento-01.jpg');
insert into Ingaggio (datore, titolo, descrizione, data_ingaggio, id_luogo, immagine, compenso_indicativo, ora_inizio, ora_fine) values (4, 'Festival della musica', 'Questo festival si terrà sem duis aliquam convallis nunc proin at turpis a pede posuere nonummy integer non velit donec diam neque', '12.11.2023', null, 1004, 268.09, '20:00:00', '1:00:00');
