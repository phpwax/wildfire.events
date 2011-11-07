<?

//add in the custom model setup for the competition
WaxEvent::add("wildfire_dynamic_content.setup", function(){
  $obj = WaxEvent::data();
  $obj->define("event_item", "BooleanField", array('group'=>'event', 'label'=>'Is an event'));
  $obj->define("event_date_start", "DateTimeField", array('group'=>'event', 'label'=>'Event start','output_format'=>"j F Y",'input_format'=>"j F Y H:i", 'default'=>date("Y-m-d") ));
  $obj->define("event_date_end", "DateTimeField", array('group'=>'event', 'label'=>'Event end','output_format'=>"j F Y",'input_format'=>"j F Y H:i", 'default'=>date("Y-m-d",mktime(0,0,0, date("m"), date("j")+10, date("y") )) ));
  $obj->define("event_address", "TextField", array('group'=>'event'));
  $obj->define("event_postcode", "CharField", array('group'=>'event'));    
  $obj->define("event_featured", "BooleanField", array('group'=>'event', 'label'=>'Featured event?'));
  $obj->define("event_featured_position", "IntegerField", array('group'=>'event', 'label'=>'Position'));
  
});

?>