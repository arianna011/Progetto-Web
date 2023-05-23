<h4 class="text-orange mt-4 mb-4">Immagini </h4>

<form id="caricaProfiloUtente" action="./caricaImmagine.php" method="POST" enctype="multipart/form-data">
  <div class="col-md-6"> 
  <label class="form-label" for="profiloUtente"> Immagine Profilo Utente </label>
      <div class="input-group">
      <input type="file" class="form-control" id="profiloUtente" name="profiloUtente">
      <input type="submit" class="btn btn-outline-secondary" name="caricaProfiloUtente">
      </div>
      <div class="form-text">Scegli un'immagine di dimensione minima 200 x 200 pixel</div>
          
  </div>
</form>

