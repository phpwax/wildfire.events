<?
class WildfireEventsController extends ApplicationController {
  public $cms_live_scope = "event";
  public $per_page = 3;
  public $months_events = array();

  public function controller_global(){
    WaxEvent::add("cms.cms_stack_set", function(){
      $obj = WaxEvent::data();
      array_unshift($obj->cms_stack, $this->controller);
    });    
    parent::controller_global();
  }
  
  public function __calendar(){
    if(!$cal_month = Request::get('month')) $cal_month = date("m");
    elseif($cal_month < 10) $cal_month = "0".str_replace("0", "", $cal_month);
    if(!$cal_year = Request::get('year')) $cal_year = date("Y");
    $model = new $this->cms_content_class();
    $model = $model->scope($this->cms_live_scope);
    $cal = new Calendar();
    
    if(($events = $cal->event_range_filter($model, $cal_year, $cal_month)->all()) && $events->count()){
      foreach($events as $event){
        $index = date("Y-n-j", strtotime($event->event_date_start));
        $this->months_events[$index][$event->primval] = $event;
        if($event->event_date_end > $event->event_date_start){
          $min = date("Ymd", strtotime($event->event_date_start));
          $max = date("Ymd", strtotime($event->event_date_end));
          foreach(range($min, $max) as $i){
            $ind = date("Y-n-j", strtotime($i));
            $this->months_events[$ind][$event->primval] = $event;
          }
        }
      }
    }
  }

}
?>
?>