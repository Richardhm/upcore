/*=========================================================================================
    File Name: form-repeater.js
    Description: form repeater page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(function () {
    //'use strict';
    //var ii = 10;
    //var $items = this.$repeater.find('[parcelas]');
    // form repeater jquery
    $('.invoice-repeater').repeater({
    //   initEmpty: true,
      // setup: function () {
      //   this.ii = 1,
      //   $item = this.$repeater.find('[parcelas]'); 
      // },
      
      // defaultValues: {
      //   'parcelas' : 1+1
      //   //'parcelas': $item.length
      // },
      show: function () {
        $(this).slideDown();
        
        
      },
      hide: function (deleteElement) {
        $(this).slideUp(deleteElement);
        // if (confirm('Tem certeza que deseja deletar esse elemento?')) {
        //   $(this).slideUp(deleteElement);
        // }
      },
      ready: function (setIndexes) {
      //   $dragAndDrop.on('drop', setIndexes);
        console.log(setIndexes)
      },
     
    });
  
    function getIndex(item){
      let index = $(item);
      console.log("index >>", index);
    }
    
  
  });
  
  
  