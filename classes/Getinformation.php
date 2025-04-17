<?php
namespace App;

require_once"DataBaseQuery.php";

class Getinformation {
  //information given by user
  private $district;
  private $municipality;
  private $mapnumber;
  private $kitanumber;
  private $area;

  //databasequery conn
  private $db;

  //data extracted from database
  private $DMID;
  // private $landDetails;
  private $landRateID;
  // private $buildingInfo;
  private $citizenID;
  private $landID;
  


  public function __construct($district,$municipality,$mapnumber,$kitanumber,$area)
  {
    //object created for database query
    $this->db = new DataBaseQuery();

    //storing information in private properties
    $this->district = $district;
    $this->municipality = $municipality;
    $this->mapnumber = $mapnumber;
    $this->kitanumber = $kitanumber;
    $this->area = $area;

  }

  //calls all the function for getting data
  public function getAllData()
  {
    //query DISTRICTMUNICIPALITY TABLE for dmid 
    $this->DMID = $this->getDistrictMunicipalityID();
    //check if no item
    if(!$this->DMID){
      return ['error' => 'invalid district or muncipality'];
    }

    //landdetail table
    $landData = $this->getLandDeatils();
    if(empty($landData)){
      return ['error'=> 'land details not present in database'];
    }
    //array form data
    $data = $landData[0];
    $this->citizenID = $data['citizenID'];
    $this->landRateID = $data['landRateID'];
    $this->landID = $data['id'];
    $area_in_feet = $data['area_in_feet'];

    // In getAllData(), before calling getBuildingInfo():
// error_log("DMID: " . $this->DMID);
// error_log("landRateID: " . $this->landRateID);
// error_log("Building Type: " . $data['buildingType']);
    //check if building is constructed in land
    //check for building information
    $buildingInfo = null;
    if(!empty($data['buildingType']) && !empty($data['buildingArea'])){
       //get building rate
        $buildingRate = $this->getBuildingInfo($data['buildingType'],
      $this->DMID, $this->landRateID);

      $buildingInfo = [
        'type' => $data['buildingType'],
        'area' => $data['buildingArea'],
        'rate' => $buildingRate['Rate']
      ];
    }
    
    //now lets get landrates data from table
    $landrateData = $this->getLandRate();
    if(empty($landrateData))
    {
      return ['error'=> 'landRate is not present '];
    }
    
    //now citizen information
    $citizenInfo = $this->getCitizenDetails();
    if(empty($citizenInfo)){
      return ['error'=> 'no citizendata found in database'];
    }


    //other part 
    return [
      "checkCitizenId" => $this->citizenID,
      "landrate"       => $landrateData,
      "area_in_feet"   => $area_in_feet,
      "UserInfo"       => $citizenInfo,
      "buildingInfo"   => $buildingInfo
  ];
    
  }
  //getting DMID
  private function getDistrictMunicipalityID()
  {
    $query = "SELECT id FROM dmtable WHERE district = ? AND municipality = ?  ";
    $param = [$this->district, $this->municipality];
    $types = "ss";

    $result = $this->db->fetchData($query, $param, $types);

    return $result[0]["id"] ?? null;
    //passes the id got from database to DMID
  }

  //getting landdetails
  private function getLandDeatils(){
    $query = "SELECT id, citizenID, landRateID, area_in_feet,buildingType,buildingArea FROM landdetails WHERE DMID = ? AND kitanumber = ?
    AND areaFormat = ? AND map_number = ?";
    $param = [$this->DMID,$this->kitanumber, $this->area, $this->mapnumber];
    $types = "isss";
    $result = $this->db->fetchData($query, $param, $types);
    return $result ?? null;
  }
  //get landrate
  private function getLandRate()
  {
    $query = "SELECT locationName, rateper_anna,road_type,road_diameter FROM 
    landrates WHERE id = ?";
    $param = [$this->landRateID];
    $type = "i";
    $result = $this->db->fetchData($query, $param, $type);
    return $result[0] ?? null;
  }
  //get citizenDetails
  private function getCitizenDetails()
  {
    $query = "SELECT name,citizenship_num,email FROM citizen WHERE 
    id = ?";
    $param = [$this->citizenID ];
    $types = "i"; 
    $result = $this->db->fetchData($query, $param, $types);
    return $result[0] ?? null;
  }
  //get building info if present
  private function getBuildingInfo($buildingType,$dmid, $lrid)
  {
    $query = "SELECT Rate FROM buildingvaluetion WHERE buildingtype = ? AND
    DMID = ? AND LRID = ?";
    $param = [$buildingType ,$dmid,$lrid    ] ;
    $type = "sii";
    $result = $this->db->fetchData($query, $param, $type);

        // error_log("Building Info Query: " . $query);
        // error_log("Params: " . print_r($param, true));
        // error_log("Result: " . print_r($result, true));
    return $result[0] ?? ['Rate' => null];
  }
}
?>