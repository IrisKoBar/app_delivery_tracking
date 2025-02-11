<?php
/*
* DeliveryTracking 
* @package project
* @author Wizard <sergejey@gmail.com>
* @copyright http://majordomo.smartliving.ru/ (c)
* @version 0.1 (wizard, 14:01:59 [Jan 23, 2025])
*/
class app_delivery_tracking extends module {
//конструктор класу
	function __construct()
	{
		$this->name="app_delivery_tracking";
		$this->title="DeliveryTracking";
		$this->module_category="<#LANG_SECTION_APPLICATIONS#>";
		$this->checkInstalled();
	}
//збереження параметрів
	function saveParams($data=1)
	{
		$p=array();
		if (isset($this->id))
		{
			$p["id"]=$this->id;
		}
		if (isset($this->view_mode))
		{
			$p["view_mode"]=$this->view_mode;
		}
		if (isset($this->edit_mode))
		{
			$p["edit_mode"]=$this->edit_mode;
		}
		if (isset($this->tab))
		{
			$p["tab"]=$this->tab;
		}
		return parent::saveParams($p);
	}
//отримання параметрів
	function getParams()
	{
		global $id;
		global $mode;
		global $view_mode;
		global $edit_mode;
		global $tab;
		if (isset($id))
		{
			$this->id=$id;
		}
		if (isset($mode))
		{
			$this->mode=$mode;
		}
		if (isset($view_mode))
		{
			$this->view_mode=$view_mode;
		}
		if (isset($edit_mode))
		{
			$this->edit_mode=$edit_mode;
		}
		if (isset($tab))
		{
			$this->tab=$tab;
		}
	}
//запуск
	function run()
	{
		global $session;
		$out=array();
		if ($this->action=='admin')
		{
			$this->admin($out);
		}
		else
		{
			$this->usual($out);
		}
		if (isset($this->owner->action))
		{
			$out['PARENT_ACTION']=$this->owner->action;
		}
		if (isset($this->owner->name))
		{
			$out['PARENT_NAME']=$this->owner->name;
		}
		$out['VIEW_MODE']=$this->view_mode;
		$out['EDIT_MODE']=$this->edit_mode;
		$out['MODE']=$this->mode;
		$out['ACTION']=$this->action;
		$out['TAB']=$this->tab;
		$this->data=$out;
		$p=new parser(DIR_TEMPLATES.$this->name."/".$this->name.".html", $this->data, $this);
		$this->result=$p->result;
	}
//адмін сторінка
	function admin(&$out)
	{
		$this->getConfig();
		if(!isset($this->config['TASK_FLAG'])) $this->config['TASK_FLAG'] = false;
		$out['TASK_FLAG'] = (bool) $this->config['TASK_FLAG'];
		if(!isset($this->config['API_KEY']) || $this->config['API_KEY'] == '') $this->config['API_KEY'] = false;
		$out['API_KEY'] = ($this->config['API_KEY'] != false && $this->config['API_KEY'] != '') ? (string) $this->config['API_KEY'] : false;
		if(!isset($this->config['PREFIX']) || $this->config['PREFIX'] == '') $this->config['PREFIX'] = false;
		$out['PREFIX'] = ($this->config['PREFIX'] != false && $this->config['PREFIX'] != '') ? (string) $this->config['PREFIX'] : false;
		if(!isset($this->config['UPDATE_COMAND']) || $this->config['UPDATE_COMAND'] == '') $this->config['UPDATE_COMAND'] = false;
		$out['UPDATE_COMAND'] = $this->config['UPDATE_COMAND'];
		if(!isset($this->config['START_WITH']) || $this->config['START_WITH'] == '') $this->config['START_WITH'] = '12:00';
		$out['START_WITH'] = (string) $this->config['START_WITH'];
		if(!isset($this->config['FINISH_BEFORE']) || $this->config['FINISH_BEFORE'] == '') $this->config['FINISH_BEFORE'] = '18:00';
		$out['FINISH_BEFORE'] = (string) $this->config['FINISH_BEFORE'];
		if(!isset($this->config['SET_LANG'])) $this->config['SET_LANG'] = 'AS_IS';
		$out['SET_LANG'] = (string) $this->config['SET_LANG'];
		if(!isset($this->config['LVL'])) $this->config['LVL'] = 0;
		$out['LVL'] = (int) $this->config['LVL'];
		if(!isset($this->config['EVERY_HOUR'])) $this->config['EVERY_HOUR'] = false;
		$out['EVERY_HOUR'] = (int) $this->config['EVERY_HOUR'];
		if(!isset($this->config['AUTO_ARCHIVED'])) $this->config['AUTO_ARCHIVED'] = false;
		$out['AUTO_ARCHIVED'] = (bool) $this->config['AUTO_ARCHIVED'];
		if(!isset($this->config['SAY_UPDATE'])) $this->config['SAY_UPDATE'] = false;
		$out['SAY_UPDATE'] = (bool) $this->config['SAY_UPDATE'];
		if(!isset($this->config['LOG_OK'])) $this->config['LOG_OK'] = false;
		$out['LOG_OK'] = (bool) $this->config['LOG_OK'];
		if(!isset($this->config['LAST_UPDATE_TIME'])) $this->config['LAST_UPDATE_TIME'] = false;
		$out['LAST_UPDATE_TIME'] = $this->config['LAST_UPDATE_TIME'];
		$out['TIME_COUNT'] = $this->updTimeString($out);
		
		if ($this->view_mode=='update_settings')
		{
			$this->config['API_KEY'] = ((string) gr('api_key') != '') ? (string) gr('api_key') : false;
			$this->config['PREFIX'] = ((string) gr('prefix') != '') ? (string) gr('prefix') : false;
			$this->config['UPDATE_COMAND'] = ((string) gr('update_comand') != '') ? (string) gr('update_comand') : false;
			$this->config['AUTO_ARCHIVED'] = (bool) gr('auto_archived');
			$this->config['SAY_UPDATE'] = (bool) gr('say_update');
			$this->config['LVL'] = (int) gr('lvl');
			$this->config['EVERY_HOUR'] = ((int) gr('every_hour') != 0) ? (int) gr('every_hour') : false;
			$this->config['START_WITH'] = (string) gr('start_with');
			$this->config['FINISH_BEFORE'] = (string) gr('finish_before');
			$this->config['ARR_TIME'] = $this->UpdTimeArr(gr('start_with'), gr('finish_before'), (int) gr('every_hour'));
			$this->config['SET_LANG'] = (string) gr('set_lang');
			$this->config['LOG_OK'] = (bool) gr('log_ok');
			$this->saveConfig();
			$this->redirect("?view_mode=settings_delivery");
		}
		if (isset($this->data_source) && !$_GET['data_source'] && !$_POST['data_source'])
		{
			$out['SET_DATASOURCE'] = 1;
		}
		if ($this->data_source=='delivery' || $this->data_source=='')
		{
			if ($this->view_mode=='' || $this->view_mode=='search_delivery')
			{
				$this->search_delivery($out);
				if($this->mode=='list')
				{
				    $data = $this->createCurlResp('LIST');
    		        $this->updateDeliveryTrack($data);
				    $this->redirect("?");
				}
			}
			if ($this->view_mode=='search_archive_delivery')
			{
				$this->search_archive_delivery($out);
			}
			if ($this->view_mode=='edit_delivery')
			{
				$this->edit_delivery($out, $this->id);
			}
			if ($this->view_mode=='view_delivery')
			{
				$this->view_delivery($out, $this->id);
			}
			if ($this->view_mode=='create_delivery' && $this->mode=='create')
			{
				$this->create_delivery($out);
			}
			if ($this->view_mode=='move_delivery')
			{
				$this->move_delivery($this->id);
				$this->redirect("?");
			}
			if ($this->view_mode=='delete_delivery')
			{
				$this->delete_delivery($this->id);
				$this->redirect("?view_mode=search_archive_delivery");
			}
			if ($this->view_mode=='restore_delivery')
			{
			    $this->restore_delivery($this->id);
				$this->redirect("?view_mode=search_archive_delivery");
			}
		}
		//say(json_encode($this->config));
	}
//юзер сторінка
	function usual(&$out)
	{
		$this->admin($out);
	}
//список всіх відправлень
	function search_delivery(&$out)
	{
        $out['RESULT'] = SQLSelect("SELECT * FROM delivery ORDER BY START_DATA DESC");
	}
//перегляд архіву
    function search_archive_delivery(&$out)
    {
        $out['RESULT'] = SQLSelect("SELECT * FROM delivery_archived ORDER BY ARCHIVED_DATA DESC");
    }
//перегляд відправлення
	function view_delivery(&$out, $id)
	{
        $rec = SQLSelectOne("SELECT * FROM delivery WHERE ID='".$id."'");
        $recEv = SQLSelect("SELECT * FROM delivery_events WHERE POST_ID ='".$rec['POST_ID']."' ORDER BY EVENT_DATA DESC");
        $out['RESULT'] = $rec;
        $out['EVENTS'] = $recEv;
        $out['ID'] = $rec['ID'];
	}
//редагування відправлення
	function edit_delivery(&$out, $id)
	{
        $rec = SQLSelectOne("SELECT * FROM delivery WHERE ID='".$id."'");
        if ($this->mode == 'update')
        {
        	$rec['DESCRIPTION'] = gr('description');
        	$out['OK'] = SQLUpdate('delivery', $rec);
        }
        outHash($rec, $out);
	}
//видалення відправлення
    function delete_delivery($id)
	{
	    SQLExec("DELETE FROM delivery_archived WHERE ID='".$id."'");
	}
//перенесення в архів
	function move_delivery($id)
	{
	    //{"status":"UPDATED","pkgId":64906296,"trackCode":"LP00707359411717"}
	    $rec = SQLSelectOne("SELECT * FROM delivery WHERE ID='".$id."'");
	    if(isset($rec['ID']))
	    {
	        $data = $this->createCurlResp('MOVE', $rec['POST_ID']);
	        if(isset($data['status']) && $data['status'] == 'UPDATED')
	        {
        		$arch['POST_ID'] = $rec['POST_ID'];
        		$arch['TRACK'] = $rec['TRACK'];
        		$arch['DESCRIPTION'] = $rec['DESCRIPTION'];
        		$arch['START_DATA'] = $rec['START_DATA'];
        		$arch['LAST_DATA'] = $rec['LAST_CHANGE'];
        		$arch['IN_WAY'] = $rec['IN_WAY'];
        		$arch['ARCHIVED_DATA'] = date('Y-m-d H:i:s');
        		$arch['ID'] = SQLInsert('delivery_archived', $arch);
        		
        		SQLExec("DELETE FROM delivery WHERE ID='".$id."'");
        		SQLExec("DELETE FROM delivery_events WHERE POST_ID='".$arch['POST_ID']."'");
	        }
            else
	        {
	            $this->deliveryLog($data);
	        }
	    }
	    else
	    {
	        $this->deliveryLog('Delivery '.$id.' does not exist');
	    }
	}
//відновдення з архіву
	function restore_delivery($id)
	{
	    //{"status":"UPDATED","pkgId":65440142,"trackCode":"MGRAE0011895283YQ"}
	    $rec = SQLSelectOne("SELECT * FROM delivery_archived WHERE ID='".$id."'");
	    if(isset($rec['ID']))
	    {
	        $data = $this->createCurlResp('RESTORE', $rec['POST_ID']);
	        if(isset($data['status']) && $data['status'] == 'UPDATED')
	        {
                $sql['POST_ID'] = $data['pkgId'];
                $sql['TRACK'] = $data['trackCode'];
                $taskTime = time()+60;
                $sql['TASK'] = strval($taskTime).':LIST';
                $sql['ID'] = SQLInsert('delivery', $sql);
                $this->config['TASK_FLAG'] = true;
                $this->saveConfig();
                SQLExec("DELETE FROM delivery_archived WHERE ID='".$id."'");
	        }
            else
	        {
                $this->deliveryLog($data);
	        }
	    }
	    else
	    {
	        $this->deliveryLog('Delivery '.$id.' does not exist');
	    }
	}
//створення нового відправлення
    function create_delivery(&$out)
    {
        //{"status":"CREATED","pkgId":65440142,"trackCode":"MGRAE0011895283YQ"}
        if(isset($out['NEW_TRACK']) && $out['NEW_TRACK'] != '' && $this->mode != 'create')
        {
            //дані отримані з командної строки
            $newTrack = $out['NEW_TRACK'];
            $newDescr = '';
        }
        elseif ($this->mode == 'create')
        {
            //дані отримані з форми
            $newTrack = gr('new_track');
            $newDescr = gr('new_descr');
        }
        if(isset($newTrack) && $newTrack != '')
        {
            $rec = SQLSelectOne("SELECT * FROM delivery WHERE TRACK='".$newTrack."'");
            if(isset($rec['ID']))
            {
                $str = "<#LANG_DT_MSG_ALREADY#>";
                $out['OK'] = 2;
            }
            else
            {
                $data = $this->createCurlResp('CREATE', $newTrack);
                if(isset($data['status']) && $data['status'] == 'CREATED')
                {
		            $out['OK'] = 1;
                    $str = "<#LANG_DT_MSG_CREATE#>";
                    $sql['POST_ID'] = $data['pkgId'];
                    $sql['TRACK'] = $data['trackCode'];
                    $sql['DESCRIPTION'] = $newDescr ?? '';
                    $taskTime = time()+60;
                    $sql['TASK'] = strval($taskTime).':LIST';
                    $sql['ID'] = SQLInsert('delivery', $sql);
                    $this->config['TASK_FLAG'] = true;
                    $this->saveConfig();
                }
                else
                {
                    $str = "<#LANG_DT_MSG_CREATE_ERR#>";
                    $this->deliveryLog($data);
                    $out['OK'] = 0;
                }
            }
            $out['INFO'] = $str;
        }
        else
        {
            $this->deliveryLog('New track is null.');
        }
    }

//реакція на підписані івенти
    function processSubscription($event, $details = '')
    {
    	$this->getConfig();
    	if((bool) $this->config['API_KEY'])
    	{  
// івент команда
        	if ($event=='COMMAND' && (bool) $this->config['PREFIX'] && (bool) $this->config['UPDATE_COMAND'])
        	{
        	    $cmdUpd = addcslashes((string) $this->config['UPDATE_COMAND'], '\[]()^.|?*+{}$');
        	    $pre = addcslashes((string) $this->config['PREFIX'], '\[]()^.|?*+{}$');
        	    $message=$details['message']; //саме сповіщення
    		    $matchTrack = preg_match('@^'.$pre.'\s*([a-zA-Z]{0,}[0-9]{5,}[a-zA-Z]{0,})$@', $message, $matches);
    		    $matchUpd = preg_match('@^'.$pre.'\s*'.$cmdUpd.'$@', $message);
    		    if($matchUpd)
    		    {
    		        //команда на оновлення
    		        $data = $this->createCurlResp('LIST');
    		        $this->updateDeliveryTrack($data);
    		    }
    		    elseif ($matchTrack && !$matchUpd)
    		    {
    		        //команда на створення нового треку
    		        $out['NEW_TRACK'] = $matches[1];
    		        $this->create_delivery($out);
    		    }
        	}
// івент щогодини
        	if ($event=='HOURLY' && $this->config['EVERY_HOUR'])
        	{
                $arrTime = $this->config['ARR_TIME'];
                if(is_array($arrTime))
                {
                    $hourNow = (int)date('H');
                    if(in_array($hourNow, $arrTime))
                    {
						$data = $this->createCurlResp('LIST');
						$this->updateDeliveryTrack($data);
                    }
                }
        	}
// івент щохвилини
        	if ($event=='MINUTELY' && (bool) $this->config['TASK_FLAG'])
        	{
        		$rec = SQLSelect('SELECT ID, TASK FROM delivery WHERE TASK <> ""');
        		if(!isset($rec[0]))
        		{
        		    $this->config['TASK_FLAG'] = false;
                    	    $this->saveConfig();
        		}
        		else
        		{
        		    $countFlag = true;
        		    foreach($rec as $task)
        		    {
        		        $id = $task['ID'];
        		        $arrTask = explode(':', $task['TASK']);
        		        $timeTask = (int)$arrTask[0];
        		        if(time() >= $timeTask && $countFlag)
        		        {
        		            //стираємо запис про завдання
        		            $sql['ID'] = $id;
        		            $sql['TASK'] = "";
        		            SQLUpdate('delivery', $sql);
        		            //знімаємо флаг
        		            $countFlag = false;
        		            //виконуємо завдання
        		            if($arrTask[1] == 'LIST')
        		            {
        		                $data = $this->createCurlResp('LIST');
    		                    	$this->updateDeliveryTrack($data);
        		            }
        		            elseif($arrTask[1] == 'MOVE')
        		            {
        		                $this->move_delivery($id);
        		            }
        		        }
        		    }
        		}
        	}
    	}
    }
//оновлення треків
    function updateDeliveryTrack($data)
    {
        $this->getConfig();
        if(isset($data['status']) && isset($data['totalActive']) && $data['status'] == 'SUCCESS' && $data['totalActive'] > 0)
        {
        	//$sqlEv = array();
        	foreach($data['pkgs'] as $track)
            {
            	$sql = array();
            	$sql['POST_ID'] = $track['id'];
            	$sql['TRACK'] = $track['trackCode'];
            	$sql['DEST'] = $track['destination'];
            	$sql['WEIGHT'] = $track['weight'];
            	$sql['ADDRESS'] = $track['toAddress'];
            	$sql['ADDRESSEE'] = $track['addressee'];
            	$sql['SERVICE_TYPE'] = $track['serviceType'];
            	$sql['URL'] = $track['publicUrl'];
            	$sql['START_DATA'] = date('Y-m-d H:i:s', strtotime($track['created']));
            	$sql['LAST_CHANGE'] = ($track['lastFetched'])? date('Y-m-d H:i:s', strtotime($track['lastFetched'])): date('Y-m-d H:i:s');
            	$ev = array();
            	$i=0;
            	foreach($track['events'] as $event)
                {
                	if($event['id'] != 0)
                    {
                    	$ev[$i]['TIME'] = strtotime($event['dt']);
						$ev[$i]['EVENT_ID'] = $event['id'];
						$ev[$i]['EVENT_DATA'] = date('Y-m-d H:i:s', $ev[$i]['TIME']);
                    	$ev[$i]['EVENT_DESC'] = addslashes($event['dsc']);
                    	$ev[$i]['EVENT_LOCATION'] = addslashes($event['location']);
                    	$ev[$i]['CARRIER'] = $event['carrier'];
                    	$i++;
                    }
                }
            	$sql['LAST_DATA'] = (count($ev) > 0) ? $ev[count($ev)-1]['EVENT_DATA'] : "";
            	$sql['LAST_DESC'] = (count($ev) > 0) ? $ev[count($ev)-1]['EVENT_DESC'] : "";
            	$sql['LAST_LOCATION'] = (count($ev) > 0) ? $ev[count($ev)-1]['EVENT_LOCATION'] : "";
				$sql['IN_WAY'] = (count($ev) > 0) ? round(($ev[count($ev)-1]['TIME'] - $ev[0]['TIME']) / 86400) : 0;
            	$lastActive = round((time() - strtotime($sql['LAST_CHANGE'])) / 86400);
            	$sql['NO_ACTIVE'] = ($lastActive > 3)? 1 : 0;
            	$sql['TASK'] = ((bool) $this->config['AUTO_ARCHIVED'] && $lastActive > 5)? strval(time()+60).':MOVE' : "";
            	
            	$rec = SQLSelectOne('SELECT * FROM delivery WHERE POST_ID = "'.$sql['POST_ID'].'"');
            	if(!isset($rec['ID']))
                {
                	$sql['ID'] = SQLInsert('delivery', $sql);
        		}
        		else
        		{
        			$sql['ID'] = $rec['ID'];
        			SQLUpdate('delivery', $sql);
        		}
        		if($sql['TASK'] != "")
        		{
					$this->config['TASK_FLAG'] = true;
                    $this->saveConfig();
        		}
        		if((bool) $this->config['SAY_UPDATE'])
                {
                    $rec = SQLSelectOne('SELECT MAX(EVENT_DATA) AS MAXDATA FROM delivery_events WHERE POST_ID = "'.$sql['POST_ID'].'"');
                    $oldTime = (isset($rec['MAXDATA']))? strtotime($rec['MAXDATA']) : 0;
                    $newTime = (count($ev) > 0)? $ev[count($ev)-1]['TIME'] : 0;
                    if($newTime > $oldTime)
                    {
                        $rec = SQLSelectOne('SELECT * FROM delivery WHERE POST_ID = "'.$sql['POST_ID'].'"');
                        $name = ($rec['DESCRIPTION'] != "")? $rec['DESCRIPTION'] : $rec['TRACK'];
                        $str = $name.' - '.$ev[count($ev)-1]['EVENT_DATA'].' '.$ev[count($ev)-1]['EVENT_DESC'];
						if(isset($ev[count($ev)-1]['EVENT_LOCATION']) && $ev[count($ev)-1]['EVENT_LOCATION'] != '') $str .= ' - '.$ev[count($ev)-1]['EVENT_LOCATION'];
						$lvl = (int) $this->config['LVL'];
                        say($str, $lvl);
                    }
                }
        		if(is_array($ev) && count($ev) > 0)
        		{
        		    foreach($ev as $event)
        		    {
        		        $sqlEvent = array();
        		        $sqlEvent['POST_ID'] = $sql['POST_ID'];
						$sqlEvent['EVENT_ID'] = $event['EVENT_ID'];
						$sqlEvent['EVENT_DATA'] = $event['EVENT_DATA'];
						$sqlEvent['EVENT_DESC'] = $event['EVENT_DESC'];
						$sqlEvent['EVENT_LOCATION'] = $event['EVENT_LOCATION'];
						$sqlEvent['CARRIER'] = $event['CARRIER'];
						$rec = SQLSelectOne('SELECT * FROM delivery_events WHERE EVENT_ID = "'.$event['EVENT_ID'].'"');
						if(!isset($rec['ID']))
						{
								$sqlEvent['ID'] = SQLInsert('delivery_events', $sqlEvent);
						}
						else
						{
								$sqlEvent['ID'] = $rec['ID'];
								SQLUpdate('delivery_events', $sqlEvent);
						}
        		    }
        		}
            }
        }
        else
        {
            $this->deliveryLog($data);
        }
    }
//створюємо запит на сайт api
    function createCurlResp($metod, $track='')
    {
        $this->getConfig();
        if((bool) $this->config['API_KEY'] && (bool) $this->config['SET_LANG'])
        {
			$key = (string) $this->config['API_KEY'];
			$lng = (string) $this->config['SET_LANG'];
            $url = 'https://postal-ninja.p.rapidapi.com/v1/track';
            
            $hdr = [
            	"Accept: application/json; charset=UTF-8",
            	"x-rapidapi-host: postal-ninja.p.rapidapi.com",
            	"x-rapidapi-key: ".$key
            ];
            
            $curl = curl_init(); // ініціалізація нового сеансу мережевої передачі даних
            
            if($metod == 'CREATE')
            {
            	$prm = ['trackCode' => $track,];
            	$rc = 'POST';
            	array_push($hdr, "Content-Type: application/x-www-form-urlencoded");
            	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($prm));
            }
            elseif($metod == 'MOVE')
            {
            	$prm = ['to' => 'ARCHIVED',];
            	$rc = 'POST';
            	array_push($hdr, "Content-Type: application/x-www-form-urlencoded");
            	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($prm));
            	$url .= '/'.$track.'/move';
            }
            elseif($metod == 'RESTORE')
            {
            	$prm = ['to' => 'ACTIVE',];
            	$rc = 'POST';
            	array_push($hdr, "Content-Type: application/x-www-form-urlencoded");
            	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($prm));
            	$url .= '/'.$track.'/move';
            }
            elseif($metod == 'LIST')
            {
            	$prm = ['events' => "ALL", 'offset' => 0, 'lang' => $lng, 'max' => 20, 'list' => "ACTIVE",];
            	$rc = 'GET';
            	$url .= "?".http_build_query($prm);
            	$this->config['LAST_UPDATE_TIME'] = time();
                $this->saveConfig();
            }
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_ENCODING, "");
            curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $rc);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $hdr);
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if($err) $this->deliveryLog($err);
            else return json_decode($response, true);
        }
    }
//Обробка помилок
    function deliveryLog($message)
    {
        $this->getConfig();
        if($this->config['LOG_OK'])
        {
            //$message = (is_array($message))? json_encode($message, JSON_UNESCAPED_UNICODE) : $message;
            if(is_array($message) && isset($message['status']) && isset($message['totalActive']) && $message['status'] == 'SUCCESS' && $message['totalActive'] == 0)
            {
                $str = 'Delivery list is empty';
            }
            elseif(is_array($message) && isset($message['status']) && isset($message['msg']) && $message['status'] == 'ERROR')
            {
                $str = 'ERROR: '.$message['msg'];
            }
            elseif(is_array($message) && isset($message['message']))
            {
                $str = 'MESSAGE: '.$message['message'];
            }
            elseif(is_array($message))
            {
                $str = json_encode($message, JSON_UNESCAPED_UNICODE);
            }
            else
            {
                $str = $message;
            }
            DebMes($str, "DeliveryTracking");
        }
    }
//Оновлення данних про час
    function updTimeString(&$out)
    {
        $lastTime = $out['LAST_UPDATE_TIME'];
    	if($lastTime)
    	{
    	    $newTime = time();
            if($newTime - $lastTime > 3600)
            {
                $s = ($newTime - $lastTime) % 60;
                $m = (($newTime - $lastTime - $s) % 3600) / 60;
                $h = ($newTime - $lastTime - $m * 60 - $s) / 3600;
                $str = "<#LANG_DT_MSG_UPD_TEXT#>".strval($h)."<#LANG_DT_MSG_UPD_H#>".strval($m)."<#LANG_DT_MSG_UPD_M#>";
            }
            elseif($newTime - $lastTime > 60)
            {
                $s = ($newTime - $lastTime) % 60;
                $m = (($newTime - $lastTime - $s) % 3600) / 60;
                $str = "<#LANG_DT_MSG_UPD_TEXT#>".strval($m)."<#LANG_DT_MSG_UPD_M#>";
            }
            else
            {
                $str = "<#LANG_DT_MSG_UPD_NOW#>";
            }
    	}
    	else
    	{
    	    $str = "<#LANG_DT_MSG_UPD_NOT#>";
    	}
        return $str;
    }
//масив часу оновлень
    function UpdTimeArr($sT, $fT, $interval)
    {
        $timeArr = array();
        if(isset($interval) && (int) $interval > 0 && (string) $sT != '' && (string) $fT != '')
        {
            $interval *= 3600;
            $stArr = date_parse_from_format("H:i", $sT);
            $ftArr = date_parse_from_format("H:i", $fT);
            $fD = ($ftArr['hour'] <= $stArr['hour'])? 'tomorrow ': 'today ';
            $sT = ($stArr['minute'])? 'today '.strval($stArr['hour']+1).':00' : 'today '.strval($stArr['hour']).':00';
            $fT = $fD.strval($ftArr['hour']).':00';
            $start = strtotime($sT);
            $finish = strtotime($fT);
            while($start <= $finish)
            {
            	array_push($timeArr, (int)date('H', $start));
            	$start += $interval;
            }
        }
        else
        {
            $timeArr = false;
        }
        return $timeArr;
    }
//інсталяція і підписка на івенти
	function install($data='')
	{
		subscribeToEvent($this->name, 'COMMAND');
		subscribeToEvent($this->name, 'HOURLY');
		subscribeToEvent($this->name, 'MINUTELY');
		parent::install();
	}
//деінсталяція і відписка від івентів
	function uninstall()
	{
		unsubscribeFromEvent($this->name, 'COMMAND');
		unsubscribeFromEvent($this->name, 'HOURLY');
		unsubscribeFromEvent($this->name, 'MINUTELY');
		SQLExec('DROP TABLE IF EXISTS delivery');
		SQLExec('DROP TABLE IF EXISTS delivery_archived');
		SQLExec('DROP TABLE IF EXISTS delivery_events');
		parent::uninstall();
	}
//створення таблиці в базі
	function dbInstall($data)
	{
		$data = <<<EOD
			delivery: ID int(11) unsigned NOT NULL auto_increment
			delivery: POST_ID int(11) NOT NULL
			delivery: TRACK varchar(50) NOT NULL
			delivery: DESCRIPTION varchar(100) NULL
			delivery: WEIGHT decimal(3, 3) NULL
			delivery: ADDRESS varchar(100) NULL
			delivery: ADDRESSEE varchar(100) NULL
			delivery: DEST TINYTEXT NULL
			delivery: URL varchar(255) NULL
			delivery: START_DATA DATETIME NULL
			delivery: LAST_CHANGE DATETIME NULL
			delivery: LAST_DATA DATETIME NULL
			delivery: LAST_DESC varchar(255) NULL
			delivery: LAST_LOCATION varchar(255) NULL
			delivery: SERVICE_TYPE varchar(100) NULL
			delivery: IN_WAY tinyint(4) NULL
			delivery: NO_ACTIVE boolean NULL
			delivery: TASK varchar(50) NULL
			delivery: UPD DATETIME DEFAULT current_timestamp()
			delivery_archived: ID int(11) unsigned NOT NULL auto_increment
			delivery_archived: POST_ID int(11) NOT NULL
			delivery_archived: TRACK varchar(50) NOT NULL
			delivery_archived: DESCRIPTION varchar(50) NULL
			delivery_archived: START_DATA DATETIME NOT NULL
			delivery_archived: LAST_DATA DATETIME NOT NULL
			delivery_archived: IN_WAY tinyint(4) NOT NULL
			delivery_archived: ARCHIVED_DATA DATETIME NOT NULL
			delivery_events: ID int(11) unsigned NOT NULL auto_increment
			delivery_events: POST_ID int(11) NOT NULL
			delivery_events: EVENT_ID int(11) NOT NULL
			delivery_events: EVENT_DATA DATETIME NOT NULL
			delivery_events: EVENT_DESC varchar(255) NULL
			delivery_events: EVENT_LOCATION varchar(255) NULL
			delivery_events: CARRIER varchar(100) NULL
			EOD;
		parent::dbInstall($data);
	}
}
