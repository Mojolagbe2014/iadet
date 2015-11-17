jQuery.noConflict();
jQuery(document).ready(function() {
  
  // Tabs Shortcodes
  "use strict";
  if(jQuery('ul.dt-sc-tabs').length > 0) {
    jQuery('ul.dt-sc-tabs').jtabs('> .dt-sc-tabs-content');
  }
  
  if(jQuery('ul.dt-sc-tabs-frame').length > 0){
    jQuery('ul.dt-sc-tabs-frame').jtabs('> .dt-sc-tabs-frame-content');
  }
  
  if(jQuery('.dt-sc-tabs-vertical-frame').length > 0){
    
    jQuery('.dt-sc-tabs-vertical-frame').jtabs('> .dt-sc-tabs-vertical-frame-content');
    
    jQuery('.dt-sc-tabs-vertical-frame').each(function(){
      jQuery(this).find("li:first").addClass('first').addClass('current');
      jQuery(this).find("li:last").addClass('last');
    });
    
    jQuery('.dt-sc-tabs-vertical-frame li').click(function(){
      jQuery(this).parent().children().removeClass('current');
      jQuery(this).addClass('current');
    });
    
  }/*Tabs Shortcode Ends*/
  
  /*Toggle shortcode*/
  jQuery('.dt-sc-toggle').toggle(function(){ jQuery(this).addClass('active'); },function(){ jQuery(this).removeClass('active'); });
  jQuery('.dt-sc-toggle').click(function(){ jQuery(this).next('.dt-sc-toggle-content').slideToggle(); });
  jQuery('.dt-sc-toggle-frame-set').each(function(){
    var $this = jQuery(this),
        $toggle = $this.find('.dt-sc-toggle-accordion');
    
    $toggle.click(function(){
      if( jQuery(this).next().is(':hidden') ) {
        $this.find('.dt-sc-toggle-accordion').removeClass('active').next().slideUp();
        jQuery(this).toggleClass('active').next().slideDown();
      }
      return false;
    });
    
    //Activate First Item always
    $this.find('.dt-sc-toggle-accordion:first').addClass("active");
    $this.find('.dt-sc-toggle-accordion:first').next().slideDown();
  });/* Toggle Shortcode end*/
  
  /*Tooltip*/
  if(jQuery(".dt-sc-tooltip-bottom").length){
    jQuery(".dt-sc-tooltip-bottom").each(function(){	jQuery(this).tipTip({maxWidth: "auto"}); });
  }
  
  if(jQuery(".dt-sc-tooltip-top").length){
    jQuery(".dt-sc-tooltip-top").each(function(){ jQuery(this).tipTip({maxWidth: "auto",defaultPosition: "top"}); });
  }
  
  if(jQuery(".dt-sc-tooltip-left").length){
    jQuery(".dt-sc-tooltip-left").each(function(){ jQuery(this).tipTip({maxWidth: "auto",defaultPosition: "left"}); });
  }
  
  if(jQuery(".dt-sc-tooltip-right").length){
    jQuery(".dt-sc-tooltip-right").each(function(){ jQuery(this).tipTip({maxWidth: "auto",defaultPosition: "right"}); });
  }/*Tooltip End*/
  
  //Scroll to top
  jQuery("a.scrollTop").each(function(){
    jQuery(this).click(function(e){
      jQuery("html, body").animate({ scrollTop: 0 }, 600);
      e.preventDefault();
    });
  });//Scroll to top end
  
  //Skillset
  animateSkillBars();
  jQuery(window).scroll(function(){ animateSkillBars(); });
  function animateSkillBars(){
    var applyViewPort = ( jQuery("html").hasClass('csstransforms') ) ? ":in-viewport" : "";
    jQuery('.dt-sc-progress'+applyViewPort).each(function(){
      var progressBar = jQuery(this),
          progressValue = progressBar.find('.dt-sc-bar').attr('data-value');
      
      if (!progressBar.hasClass('animated')) {
        progressBar.addClass('animated');
        progressBar.find('.dt-sc-bar').animate({width: progressValue + "%"},600,function(){ progressBar.find('.dt-sc-bar-text').fadeIn(400); });
      }
    });
  }
});