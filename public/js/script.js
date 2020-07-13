$(document).ready(function(){
  //TOGGLE
  $('#sidebarCollapse').on('click', function() {
    $('#sidebar, #content').toggleClass('active');
  });

    //GENERATION DES CHAMPS INPUT
    $("#etudiant_adresse").hide();
    $("#etudiant_montant").hide();
    $("#etudiant_chambre").hide();

    $('#etudiant_typeEtudiant').change(function(){
      if ($('#etudiant_typeEtudiant').val()=='Non Boursier') {
        $("#etudiant_adresse").show();
        $("#etudiant_montant").hide();
        $("#etudiant_chambre").hide();
      }else if ($('#etudiant_typeEtudiant').val()=='Loger'){
        $("#etudiant_montant").show();
        $("#etudiant_chambre").show();
        $("#etudiant_adresse").hide();

      }else{
        $("#etudiant_montant").show();
        $("#etudiant_adresse").show();
        $("#etudiant_chambre").hide();
      }
  });

});
  