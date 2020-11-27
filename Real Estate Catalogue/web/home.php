<?php

class home{
    private $type;
    private $rooms;
    private $price;
    private $priceType;
    private $region;
    private $buildingType;
    private $area;
    private $agency;
    private $floorStart;
    private $floorEnd;
    private $homeLink;
    private $homeDescription;

    public $dbConn;

   function set_type($type)
   {
       switch($type)
       {
           case "apart":
                $type = "Апартамент";
                break;
           case "house":
                $type ="Къща";
                break;
            case "garage":
                $type = "Гараж";
                break;
       }
       $this->type = $type;
   }

   function set_rooms($rooms)
   {
       $this->rooms = $rooms;
   }

   function set_price($price)
   {
        $this->price = $price;
   }

   function set_priceType($priceType)
   {
       switch($priceType)
       {
           case "euro":
                $priceType = "Евро";
                break;
           case "lev":
                $priceType = "Лева";
                break;
       }
        $this->priceType = $priceType;
   }

   function set_region($region)
   {
        $this->region = $region;
   }

   function set_buildingType($type)
   {
       switch($type)
       {
        case "pan":
            $type = "Панел";
            break;
       case "tuh":
            $type ="Тухла";
            break;
        case "grad":
            $type = "Градоред";
            break;
        case "epk":
            $type = "ЕПК";
            break;
       case "pk":
            $type ="ПК";
            break;
        case "empty":
            $type = "0";
            break;
       }
       $this->buildingType = $type;
   }

   function set_area($area)
   {
       if(empty($area))
       {
           $area = 0;
       }
       $this->area = $area;
   }

   function set_agency($agency)
   {
       $this->agency = $agency;
   }

   function set_floorStart($floorStart)
   {
       $this->floorStart = $floorStart;
   }

   function set_floorEnd($floorEnd)
   {
       $this->floorEnd = $floorEnd;
   }

   function set_homeLink($homeLink)
   {
       $url = $homeLink;
       $url = filter_var($url, FILTER_SANITIZE_URL);

       if (filter_var($url, FILTER_VALIDATE_URL)) 
       {
           $this->homeLink = $url;
       } else
       {
           $this->homeLink = "Няма зададен линк";
       }
   }

   function set_description($homeDescription)
   {
       $this->homeDescription = $homeDescription;
   }

   function get_type()
    {
        return $this->type;
    }

    function get_price()
    {
        return $this->price;
    }

    function get_priceType()
    {
        return $this->get_priceType;
    }

    function get_region()
    {
        return $this->region;
    }

    function get_buildingType()
    {
        return $this->buildingType;
    }

    function get_area()
    {
        return $this->area;
    }

    function get_agency()
    {
        return $this->agency;
    }

    function get_rooms()
    {
        return $this->rooms;
    }

    function get_floorStart()
    {
        return $this->floorStart;
    }

    function get_floorEnd()
    {
        return $this->floorEnd;
    }

    function get_homeLink()
    {
        return $this->homeLink;
    }

    function get_description()
    {
        return $this->homeDescription;
    }

    public function __construct() {
        require_once("connectDB.php");
        $db = new DbConnect();
        $this->dbConn = $db->connect();
    }

    public function logIntoDb()
    {
        /*$sql = "INSERT INTO homes (homeType, homePrice, priceType, homeRegion, homeArea, homeAgency, homeEntry, homeFirstFloor, homeSecondFloor, homeURL) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->dbConn->prepare($sql);
        $stmt->bind_param('ssssssssss', $this->type, $this->price, $this->priceType, $this->region, $this->area, $this->agency, $this->rooms, $this->floorStart, $this->floorEnd, $this->homeLink);

        if($stmt->execute()){

            $_SESSION['message'] = "You are now logged in!";
            header('location: index.php');
            exit();
        }else{
            echo "dbFailed";
        }*/

        $sql = "INSERT INTO `homes`(`homeType`, `homeRooms`, `homePrice`, `priceType`, `homeRegion`, `homeBuildingType`, `homeArea`, `homeAgency`, `homeFirstFloor`, `homeSecondFloor`, `homeURL`, `homeDescription`) VALUES (:type, :rooms, :price, :priceType, :region, :buildingType, :area, :agency, :floorStart, :floorEnd, :homeLink, :description)";
			$stmt = $this->dbConn->prepare($sql);
			$stmt->bindParam(":type", $this->type);
			$stmt->bindParam(":rooms", $this->rooms);
			$stmt->bindParam(":price", $this->price);
			$stmt->bindParam(":priceType", $this->priceType);
            $stmt->bindParam(":region", $this->region);
            $stmt->bindParam(":buildingType", $this->buildingType);
            $stmt->bindParam(":area", $this->area);
			$stmt->bindParam(":agency", $this->agency);
			$stmt->bindParam(":floorStart", $this->floorStart);
			$stmt->bindParam(":floorEnd", $this->floorEnd);
            $stmt->bindParam(":homeLink", $this->homeLink);
			$stmt->bindParam(":description", $this->homeDescription);
            
            
			try {
				if($stmt->execute()) {
					return true;
				} else {
					return false;
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
    }

    public function save($type, $rooms, $price, $priceType, $region, $buildingType, $area, $agency, $floorStart, $floorEnd, $homeLink, $homeDescription)
   {
       $this->set_type($type);
       $this->set_rooms($rooms);
       $this->set_price($price);
       $this->set_priceType($priceType);
       $this->set_region($region);
       $this->set_buildingType($buildingType);
       $this->set_area($area);
       $this->set_agency($agency);
       $this->set_floorStart($floorStart);
       $this->set_floorEnd($floorEnd);
       $this->set_homeLink($homeLink);
       $this->set_description($homeDescription);
   }

   function getAll()
   {
        /*$sql = 'SELECT * FROM homes';
            
        foreach($this->dbConn->query($sql) as $row)
        {
            print $row['home_id'] . "\t";
        }*/

        //$result = $this->dbConn->query("SELECT * from homes");
        $result = $this->dbConn->query("SELECT * from homes order by home_id DESC");

        /*$rows = $result->rowCount();
        if($result->rowCount() > 0)
        {
            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                //echo $row['home_id'];
                echo json_encode($row);
            }
        }*/
        return $result;
   }

   function export()
   {
        /*header('Content-Disposition: attachment; filename=data.csv');  
        header('Content-Type: text/plain');*/
        
        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=Customers_Export.csv');
        echo "\xEF\xBB\xBF";
        $output = fopen("php://output", "w");  
        fputcsv($output, array('home_id', 'homeType', 'homeRooms', 'homePrice', 'priceType', 'homeRegion', 'homeArea', 'homeAgency', 'homeFirstFloor', 'homeSecondFloor', 'homeUrl'));  
        //$query = "SELECT * from tbl_employee ORDER BY id DESC";  
        $result = $this->dbConn->query("SELECT * from homes ORDER BY home_id");
        //$result = mysqli_query($$this->dbConn, $query);  
        while($row = $result->fetch(PDO::FETCH_ASSOC))  
        {  
            fputcsv($output, $row);  
        }  
        fclose($output);  
    }

    function deleteHome()
    {      
        $del = "";
        $result = $this->dbConn->query("SELECT * from homes");

        while($row = $result->fetch(PDO::FETCH_ASSOC))  
        {  
            $del = "delete" . $row['home_id'];
            echo $del;
            if(isset($_POST[$del]))
            {
                $sql = "DELETE FROM homes WHERE home_id = :home_id";
                $stmt = $this->dbConn->prepare($sql);

                $stmt->bindParam(':home_id', $row['home_id'], PDO::PARAM_INT);   
                $stmt->execute();

                try {
                    if($stmt->execute()) {
                        return true;
                    } else {
                        return false;
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                
            }  
        }   
			
    }

  }

?>