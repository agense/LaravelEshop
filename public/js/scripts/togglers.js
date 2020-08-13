/**
 * 
 * @param {*} btnClass  - the class name of buttons that trigger togglers
 * @param {*} targetClass - the class name of the toggled element in single toggle buttons, or the id prefix in multiple togglers
 * @param {*} changeText  - if true, will reset toggler button text
 * @param {*} showTxt - text to be added to toggler buttons for show if changeText is true
 * @param {*} hideTxt - text to be added to toggler buttons for hide if changeText is true
 * !!! if the selector passed as btnClass has many elements, each one will be toggled using data id.
 */
function initFilterTogglers(keyword){
  const filterTogglers = $(`.${keyword}`);
  Object.values(filterTogglers).forEach(element => {
      let tgId = $(element).attr('id');
      initTogglers(tgId , tgId +'-holder');
  });
}

function initTogglers(btnClass, targetClass, changeText = false, showTxt = 'Show', hideTxt = 'Hide'){ 
  let togglers = $(`.${btnClass}`);
  //Init Single Toggler
  if(togglers.length == 1 && ($(togglers).attr('data-id') == undefined)){    
      let targetEl = $(`.${targetClass}`);
      $(togglers).on('click', (e)=>{
        e.preventDefault();
        toggleElement(targetEl, togglers, changeText, showTxt, hideTxt);
      });
  }else{
  //Init Multiple Togglers
      $(togglers).each(function(index, element){
        $(element).on('click', function(e){
            e.preventDefault();
            let targetId = $(e.target).attr('data-id');
            let target = targetClass + targetId;
            let targ = $('#'+target).get( 0 );
            toggleElement(targ, e.target, changeText, showTxt, hideTxt);
        })
      });
  }
}

function toggleElement(targetEl, btn, changeText, showTxt, hideTxt){
  $(targetEl).slideToggle(300, ()=>{
        if($(targetEl).css('display') == 'block'){
          let text = (changeText == true) ? hideTxt : $(btn).text();
          $(btn).html(`${text} <i class="fas fa-chevron-up"></i></a>`);
        }else{
          let text = (changeText == true) ? showTxt : $(btn).text();
          $(btn).html(`${text} <i class="fas fa-chevron-down"></i></a>`);
        }
  });
}
