jQuery.fn.extend({
    customSerialize: function() {
      var form =  '<form>'+$(this).html()+'</form>';
      return $( form ).serialize();
    },
    customSerializeArray: function() {
      var form =  '<form>'+$(this).html()+'</form>';
      return $( form ).serializeArray();
    }
});

//window.location.href = "http://m.alebrunch-chedonna.it/app_dev.php/news/3/care_mamme_lavoratrici_ecco_10_trucchi_per_organizzare_la_casa";