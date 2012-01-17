<?
//find the content model class and set a define
if(!defined("CONTENT_MODEL")){
  $con = new ApplicationController(false, false);
  define("CONTENT_MODEL", $con->cms_content_class);
}

//add in the custom model setup for the competition
WaxEvent::add(CONTENT_MODEL.".setup", function(){
  $obj = WaxEvent::data();
  $obj->define("event_item", "BooleanField", array('group'=>'event', 'label'=>'Is an event'));
  $obj->define("event_date_start", "DateTimeField", array('group'=>'event', 'label'=>'Event start','output_format'=>"j F Y",'input_format'=>"j F Y H:i", 'default'=>date("Y-m-d") ));
  $obj->define("event_date_end", "DateTimeField", array('group'=>'event', 'label'=>'Event end','output_format'=>"j F Y",'input_format'=>"j F Y H:i", 'default'=>date("Y-m-d",mktime(0,0,0, date("m"), date("j")+10, date("y") )) ));
  $obj->define("event_address", "TextField", array('group'=>'event'));
  $obj->define("event_postcode", "CharField", array('group'=>'event'));    
  $obj->define("event_featured", "BooleanField", array('group'=>'event', 'label'=>'Featured event?'));
  $obj->define("event_featured_position", "IntegerField", array('group'=>'event', 'label'=>'Position'));
  
});
//hook in to the scope function to add filters based on the type
WaxEvent::add(CONTENT_MODEL.".scope", function(){
  $obj = WaxEvent::data();
  $scope = $obj->asked_for_scope;
    
  if($scope == "event") $obj->scope_live()->filter("event_item",1)->filter("TIMESTAMPDIFF(SECOND, `event_date_start`, NOW()) <= 0")->filter("(`event_date_end` <= `date_start` OR (`event_date_end` >= `event_date_end` AND `event_date_end` >= NOW()) )")->order("event_date_start ASC");
  else if($scope == "event_list") $obj->scope_live()->filter("event_item",1);
});

?>