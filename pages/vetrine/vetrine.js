
function get_page(){
    $(document).on('click', '.page-item', function(){
    let page = $(this).attr("id");
    //let search = $('#inputsearch').val();
    fetch_data(page);
    document.getElementById("pull_data").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
  });
};
