<?php
class Reservation {
    private static $status = array("신청", "승인", "반려", "완료");
    private $sn;
    private $status_sn;
    private $member_id;
    private $equipment_sn;
    private $start_datetime;
    private $end_datetime;
    private $memo;
    private $register_datetime;

    // Returns a member variable
    public function getSN() {
        return $this->sn;
    }

    public function getStatusSN() {
        return $this->status_sn;
    }

    public function getMemberID() {
        return $this->member_id;
    }

    public function getEquipementSN() {
        return $this->equipment_sn;
    }

    public function getStartDatetime() {
        return $this->start_datetime;
    }

    public function getEndDatetime() {
        return $this->end_datetime;
    }

    public function getMemo() {
        return $this->memo;
    }

    public function getRegisterDatetime() {
        return $this->register_datetime;
    }

    public function outputStatus() {
        return self::$status[$this->status_sn];
    }

    // Outputs the row of table on the document
    public function outputAsTableRow() {
        $table_row = "<tr>";
        $table_row .= "<td><input type='radio' name='reservation_sn' value='$this->sn'</td>";
        $table_row .= "<td>$this->sn</td>";
        $table_row .= "<td>".$this->outputStatus()."</td>";
        $table_row .= "<td>$this->member_id</td>";
        $table_row .= "<td>$this->equipment_sn</td>";
        $table_row .= "<td>$this->start_datetime</td>";
        $table_row .= "<td>$this->end_datetime</td>";
        $table_row .= "<td>$this->memo</td>";
        $table_row .= "<td>$this->register_datetime</td>";
        $table_row .= "</tr>";

        return $table_row;
    }
}