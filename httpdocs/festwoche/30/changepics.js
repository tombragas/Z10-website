(document.querySelector && document.querySelectorAll)||(function() {
      document.querySelector = function(query) {
      return document.querySelectorAll(query)[0];
      };

      document.querySelectorAll = function(query) {
      return Sizzle(query);
      }
      })();

(function() {

 function log(message) {
 window.console.log?console.log(message):alert(message);
 }

 // Selectors API, CSS Transforms

 var articles = document.querySelectorAll(".bandsite > article"), a = 0, l = articles.length;
 var slideshow = setInterval(function() {
    for(var i=(l-1); i>=0; i--) {
    articles[i].style.opacity = 0;
    }

    setTimeout(function() {
       for(var i=(l-1); i>=0; i--) {
       if(i==a) {
       articles[i].style.opacity = 1;
       } 
       }
       },000);
    if(a==(l-1)) {
    a=0;
    } else {
    a++;
    }
    }, 7000);



})();
