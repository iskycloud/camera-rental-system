<?php
class Member {
    private $id;
    private $name;
    private $tel;
    private $memo;
    private $is_admin;

    // Returns a member variable
    public function getID() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getTel() {
        return $this->tel;
    }

    public function getMemo() {
        return $this->memo;
    }

    public function IsAdmin() {
        return $this->is_admin;
    }

    // Outputs the row of table on the document
    public function outputAsTableRow() {
        $table_row = "<tr>";
        $table_row .= "<td><input type='radio' name='member_id' value='$this->id'</td>";
        $table_row .= "<td>$this->id</td>";
        $table_row .= "<td>$this->name</td>";
        $table_row .= "<td>$this->tel</td>";
        $table_row .= "<td>$this->memo</td>";
        $table_row .= "</tr>";

        return $table_row;
    }
}