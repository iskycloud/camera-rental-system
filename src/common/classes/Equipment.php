<?php
class Equipment {
    private static $types = array("카메라", "렌즈");
    private $sn;
    private $is_enabled;
    private $type_sn;
    private $manufacturer;
    private $model;
    private $memo;

    // Returns a member variable
    public function getSN() {
        return $this->sn;
    }

    public function getIsEnabled() {
        return $this->is_enabled;
    }

    public function getTypeSN() {
        return $this->type_sn;
    }

    public function getManufacturer() {
        return $this->manufacturer;
    }

    public function getModel() {
        return $this->model;
    }

    public function getMemo() {
        return $this->memo;
    }

    public function outputIsEnabled() {
        if ($this->is_enabled == TRUE) {
            return "대여가능";
        }
        else  {
            return "대여불가";
        }
    }

    public function outputType() {
        return self::$types[$this->type_sn];
    }

    // Outputs the row of table on the document
    public function outputAsTableRow() {
        $table_row = "<tr>";
        $table_row .= "<td><input type='radio' name='equipment_sn' value='$this->sn'</td>";
        $table_row .= "<td>$this->sn</td>";
        $table_row .= "<td>".$this->outputIsEnabled()."</td>";
        $table_row .= "<td>".$this->outputType()."</td>";
        $table_row .= "<td>$this->manufacturer</td>";
        $table_row .= "<td>$this->model</td>";
        $table_row .= "<td>$this->memo</td>";
        $table_row .= "</tr>";

        return $table_row;
    }
}