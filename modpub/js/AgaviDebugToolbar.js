/**
 *
 */

window.addEvent("domready", function(){

  var tabs = new SimpleTabs('sections', {
    selector: 'h2'
  });
  
  var rtabs = new SimpleTabs('section-routing', {
    selector: 'h3'
  });
  
  var atabs = new SimpleTabs('section-actions', {
    selector: 'h3'
  });

});
