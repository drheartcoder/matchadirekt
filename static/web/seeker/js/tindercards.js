/*jslint browser: true*/
/*global console, Hammer, $*/

/**
 * Tindercards.js
 *
 * @author www.timo-ernst.net
 * @module Tindercardsjs
 * License: MIT
 */
var Tindercardsjs = Tindercardsjs || {};

Tindercardsjs = (function () {
  'use strict';
  
  var exports = {};
  
  /**
   * Represents one card
   *
   * @memberof module:Tindercardsjs
   * @class
   */
  exports.card = function (cardid, name, desc, imgpath) {
    
    var jqo;
    
    /**
     * Returns a jQuery representation of this card
     *
     * @method
     * @public
     * @return {object} A jQuery representation of this card
     */
    this.tojQuery = function () {
      if (!jqo) {
        jqo = $('.tc-card').attr('data-cardid', cardid);
      }
      return jqo;
    };

  };
  
  /**
   * Initializes swipe
   *
   * @private
   * @function
   */
  function initSwipe(onSwiped) {
    var $topcard = $('.tc-card'),
      deltaX = 0;

    $topcard.each(function () {

      var $card = $(this);
      //console.log($(':nth-child(1)', this).attr('class'));
      /*if(this.hasClass('tc-card')){
        console.log('Yes');
      }*/
      //$('.response.content a.showlist')
     console.log($card.children().children().children().children().children()[0]);
     //console.log($card.children());

      (new Hammer(this)).on("panleft panright panend panup pandown", function (ev) {
        //console.log($card.next());
        var transform,
          yfactor = ev.deltaX >= 0 ? -1 : 1,
          resultEvent = {};
        var opac = 0;
        if(ev.deltaX > 0){
          if(ev.deltaX >= 15){
            if(opac <= 1){
              opac = ((opac+ev.deltaX)/60);

             $card.find('.spnRight').css({ 'opacity' : opac });
             // $( this ).find( "span" ).css( "opacity", opac );
              //$("span:first").text($(":hidden", document.body).length + " hidden elements.");
            }
          } else if(ev.deltaX > 0 && ev.deltaX < 15){
              $card.find('.spnRight').css({ 'opacity' : '0' });
             // $("span:first").text($(":hidden", document.body).length + " hidden elements.");
            }
        } 
        var opac = 0;
        if(ev.deltaX < 0){
            if(ev.deltaX <= -15){
              if(opac <= 1){
                opac = -((opac+ev.deltaX)/60);
                 $card.find(".spnLeft").css({ 'opacity' : opac });
              }
            } else if(ev.deltaX < 0 && ev.deltaX > -15){
               $card.find(".spnLeft").css({ 'opacity' : '0' });
            }
        }

        if (ev.type === 'panend') {
          if (deltaX > 100 || deltaX < -100) {
              
            transform = 'translate3d(' + (5 * deltaX) + 'px, ' + (yfactor * 1.5 * deltaX) + 'px, 0)';
            $card.css({
              'transition': '-webkit-transform 0.5s',
              '-webkit-transform': transform + ' rotate(' + ((5 * deltaX) / 10) + 'deg)'
            });


            setTimeout(function () {
              $card.css({
                'display': 'none'
              });
              if (typeof onSwiped === 'function') {
                resultEvent.cardid = $card.attr('data-cardid');
                resultEvent.card = $card;
                if (deltaX > 100) {
                  resultEvent.direction = 'right';
                } else {
                  resultEvent.direction = 'left';
                }

                onSwiped(resultEvent);

             // location.reload();
              }
              else {
                console.warn('onSwipe callback does not exist!');
              }
            }, 500);
          } else {

            //console.log('up-down');
            console.log('X: '+ev.deltaX);
            console.log('Y: '+ev.deltaY);
             $(".spnLeft").css({ 'opacity' : '0' });
             $(".spnRight").css({ 'opacity' : '0' });
            ev.preventDefault();

            transform = 'translate3d(0px, 0, 0)';
            $card.css({
              'transition': '-webkit-transform 0.3s',
              '-webkit-transform': transform + ' rotate(0deg)'
            });
            setTimeout(function () {
              $card.css({
                'transition': '-webkit-transform 0s'
              });
            }, 300);
          }
        } else if (ev.type === 'panup' || ev.type === 'pandown') {
          // No vertical scroll
          ev.preventDefault();
        } else {
          deltaX = ev.deltaX;

          transform = 'translate3d(' + deltaX + 'px, ' + (yfactor * 0.05 * deltaX) + 'px, 0)';

          $card.css({
            '-webkit-transform': transform + ' rotate(' + ((1 * deltaX) / 10) + 'deg)'
          });
        }


      });
    });
  }
  
  /**
   * Renders the given cards
   *
   * @param {array} cards The cards (must be instanceof Tindercardsjs.card)
   * @param {jQuery} $target The container in which the cards should be rendered into
   * @param {function} onSwiped Callback when a card was swiped
   * @example Tindercardsjs.render(cards, $('#main'));
   * @method
   * @public
   * @memberof module:Tindercardsjs
   */
  exports.render = function (cards, $target, onSwiped) {
    var i,
      $card;
    
    if (cards) {
      for (i = 0; i < cards.length; i = i + 1) {
        $card = cards[i].tojQuery().appendTo($target).css({
        });
        
        $card.find('.tc-card-img').css({
          'width': '100%',
          'border-radius': '10px 10px 0 0'
        });
        
        $card.find('.tc-card-name').css({
          'margin-top': '0',
          'margin-bottom': '5px'
        });
        
        $card.find('.tc-card-body').css({
          'position': 'relative',
          'left': '10px',
          'width': '280px'
        });
      }
      
      initSwipe(onSwiped);
      
    } else {
      console.warn('tindercards array empty, no cards will be displayed');
    }
  };
  
  return exports;
  
}());