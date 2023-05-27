// funzione per la paginazione dei risultati della ricerca delle vetrine
function get_page(){
    $(document).on('click', '.page-item', function(){
    let page = $(this).attr("id");
    // funzione che prende i risultati della ricerca delle vetrine
    fetch_data(page);
    // scorre la pagina verso l'alto
    document.getElementById("pull_data").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
  });
};
