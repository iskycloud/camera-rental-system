<?php

// Functions related to Alert div
function alertMessage($message) {
    echo "<div class='alert'>";
    echo "<p>" . $message . "</p>";
    echo "</div>";
}

function alertFail($message) {
    echo "<div class='alert alert-fail'>";
    echo "<p><strong>실패!</strong> " . $message . "</p>";
    echo "</div>";
}

function alertSuccess($message) {
    echo "<div class='alert alert-success'>";
    echo "<p><strong>성공!</strong> " . $message . "</p>";
    echo "</div>";
}

// Function for clearing special characters
function clearSpecialChar($string) {
    // Strip HTML Tags
    $clear = strip_tags($string);
    // Clean up things like &amp;
    $clear = html_entity_decode($clear);
    // Strip out any url-encoded stuff
    $clear = urldecode($clear);
    // Replace non-AlNum characters with space
    $clear = preg_replace('/[^A-Za-z0-9]/', ' ', $clear);
    // Replace Multiple spaces with single space
    $clear = preg_replace('/ +/', ' ', $clear);
    // Trim the string of leading/trailing space
    $clear = trim($clear);

    return $clear;
}

// Functions related to Database
function connectDB() {
    // Connect to a MySQL database using driver invocation
    try {
        $dsn = "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME;
        $dbh = new PDO($dsn, DB_USER, DB_PASSWD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbh;
    } catch (Exception $e) {
        alertFail($e->getMessage());

        return null;
    }
}

function disconnectDB(&$dbh) {
    // Disconnect a MySQL database
    $dbh = null;
}


// Functions related to Login
function login($id, $password) {
    $id = clearSpecialChar($id);
    if (strlen($id) > 0 and strlen($id) <= 80) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "SELECT id, name, tel, memo, is_admin FROM crs_member WHERE id = :id AND password = SHA(:password);";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":id", $id);
                $sth->bindParam(":password", $password);
                $sth->setFetchMode(PDO::FETCH_CLASS, "Member");
                $sth->execute();
                $dbh->commit();

                return $sth->fetch();
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return null;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return null;
    }
}

// Functions related to Member
function registerMember($id, $password, $name, $tel, $memo) {
    $id = clearSpecialChar($id);
    if (strlen($id) > 0 and strlen($id) <= 80
        and strlen($password) > 0 and strlen($password) <= 60
        and strlen($name) > 0 and strlen($name) <= 40
        and strlen($tel) > 0 and strlen($tel) <= 11) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "INSERT INTO crs_member (id, password, name, tel, memo) VALUES(:id, SHA(:password), :name, :tel, :memo);";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":id", $id);
                $sth->bindParam(":password", $password);
                $sth->bindParam(":name", $name);
                $sth->bindParam(":tel", $tel);
                $sth->bindParam(":memo", $memo);
                $sth->execute();
                $dbh->commit();

                return true;
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return false;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return false;
    }
}

function modifyMember($id, $password, $name, $tel, $memo) {
    $id = clearSpecialChar($id);
    if (strlen($id) > 0 and strlen($id) <= 80
        and strlen($password) > 0 and strlen($password) <= 60
        and strlen($name) > 0 and strlen($name) <= 40
        and strlen($tel) > 0 and strlen($tel) <= 11) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "UPDATE crs_member SET password = SHA(:password), name = :name, tel = :tel, memo = :memo WHERE id = :id;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":id", $id);
                $sth->bindParam(":password", $password);
                $sth->bindParam(":name", $name);
                $sth->bindParam(":tel", $tel);
                $sth->bindParam(":memo", $memo);
                $sth->execute();
                $dbh->commit();

                return true;
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return false;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return false;
    }
}

function deleteMember($id) {
    $id = clearSpecialChar($id);
    if (strlen($id) > 0 and strlen($id) <= 80 and $id !== "admin") {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "DELETE FROM crs_member WHERE id = :id;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":id", $id);
                $sth->execute();
                $dbh->commit();

                return true;
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return false;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return false;
    }
}

function searchAllMember() {
    $dbh = connectDB();
    if (isset($dbh)) {
        try {
            $dbh->beginTransaction();
            $sql = "SELECT id, name, tel, memo FROM crs_member;";
            $sth = $dbh->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_CLASS, "Member");
            $sth->execute();
            $dbh->commit();

            return $sth->fetchAll();
        } catch (Exception $e) {
            $dbh->rollback();
            alertFail($e->getMessage());

            return null;
        } finally {
            disconnectDB($dbh);
        }
    }
}

function searchMember($id) {
    $id = clearSpecialChar($id);
    if (strlen($id) > 0 and strlen($id) <= 80) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "SELECT id, name, tel, memo FROM crs_member WHERE id = :id;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":id", $id);
                $sth->setFetchMode(PDO::FETCH_CLASS, "Member");
                $sth->execute();
                $dbh->commit();

                return $sth->fetch();
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return null;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return null;
    }
}

// Functions related to Equipment
function registerEquipment($is_enabled, $type_sn, $manufacturer, $model, $memo) {
    if (is_numeric($is_enabled) and $is_enabled >= 0 and $is_enabled <= 1
        and is_numeric($type_sn) and $type_sn >= 0 and $type_sn <= 1
        and strlen($manufacturer) > 0 and strlen($manufacturer) <= 40
        and strlen($model) > 0 and strlen($model) <= 80) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "INSERT INTO crs_equipment (is_enabled, type_sn, manufacturer, model, memo) VALUES(:is_enabled, :type_sn, :manufacturer, :model, :memo);";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":is_enabled", $is_enabled);
                $sth->bindParam(":type_sn", $type_sn);
                $sth->bindParam(":manufacturer", $manufacturer);
                $sth->bindParam(":model", $model);
                $sth->bindParam(":memo", $memo);
                $sth->execute();
                $dbh->commit();

                return true;
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return false;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return false;
    }
}

function modifyEquipment($sn, $is_enabled, $type_sn, $manufacturer, $model, $memo) {
    if (is_numeric($sn) and $sn >= 0
        and is_numeric($is_enabled) and $is_enabled >= 0 and $is_enabled <= 1
        and is_numeric($type_sn) and $type_sn >= 0 and $type_sn <= 1
        and strlen($manufacturer) > 0 and strlen($manufacturer) <= 40
        and strlen($model) > 0 and strlen($model) <= 80) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "UPDATE crs_equipment SET is_enabled = :is_enabled, type_sn = :type_sn, manufacturer = :manufacturer, model = :model, memo = :memo WHERE sn = :sn;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":sn", $sn);
                $sth->bindParam(":is_enabled", $is_enabled);
                $sth->bindParam(":type_sn", $type_sn);
                $sth->bindParam(":manufacturer", $manufacturer);
                $sth->bindParam(":model", $model);
                $sth->bindParam(":memo", $memo);
                $sth->execute();
                $dbh->commit();

                return true;
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return false;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return false;
    }
}

function deleteEquipment($sn) {
    if (is_numeric($sn) and $sn >= 0) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "DELETE FROM crs_equipment WHERE sn = :sn;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":sn", $sn);
                $sth->execute();
                $dbh->commit();

                return true;
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return false;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return false;
    }
}

function searchAllEquipment() {
    $dbh = connectDB();
    if (isset($dbh)) {
        try {
            $dbh->beginTransaction();
            $sql = "SELECT sn, is_enabled, type_sn, manufacturer, model, memo FROM crs_equipment;";
            $sth = $dbh->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_CLASS, "Equipment");
            $sth->execute();
            $dbh->commit();

            return $sth->fetchAll();
        } catch (Exception $e) {
            $dbh->rollback();
            alertFail($e->getMessage());

            return null;
        } finally {
            disconnectDB($dbh);
        }
    }
}

function searchEquipment($sn) {
    if (is_numeric($sn) and $sn >= 0) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "SELECT sn, is_enabled, type_sn, manufacturer, model, memo FROM crs_equipment WHERE sn = :sn;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":sn", $sn);
                $sth->setFetchMode(PDO::FETCH_CLASS, "Equipment");
                $sth->execute();
                $dbh->commit();


                return $sth->fetch();
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return null;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return null;
    }
}

function isEnabledEquipment($sn) {
    if (is_numeric($sn) and $sn >= 0) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "SELECT sn, is_enabled, type_sn, manufacturer, model, memo FROM crs_equipment WHERE sn = :sn AND is_enabled = TRUE;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":sn", $sn);
                $sth->setFetchMode(PDO::FETCH_CLASS, "Equipment");
                $sth->execute();
                $dbh->commit();

                if (!empty($sth->fetch())) {
                    return true;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return false;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return false;
    }
}

// Functions related to Reservation
function registerReservation($member_id, $equipment_sn, $start_datetime, $end_datetime, $memo) {
    $member_id = clearSpecialChar($member_id);
    $start_dt = new DateTime($start_datetime);
    $end_dt = new DateTime($end_datetime);
    if (strlen($member_id) > 0 and strlen($member_id) <= 80
        and is_numeric($equipment_sn) and $equipment_sn >= 0
        and $start_dt < $end_dt) {
        $dbh = connectDB();
        if (isset($dbh) && isEnabledEquipment($equipment_sn)) {
            try {
                $dbh->beginTransaction();
                $sql = "INSERT INTO crs_reservation (member_id, equipment_sn, start_datetime, end_datetime, memo) VALUES(:member_id, :equipment_sn, :start_datetime, :end_datetime, :memo);";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":member_id", $member_id);
                $sth->bindParam(":equipment_sn", $equipment_sn);
                $sth->bindParam(":start_datetime", $start_datetime);
                $sth->bindParam(":end_datetime", $end_datetime);
                $sth->bindParam(":memo", $memo);
                $sth->execute();
                $dbh->commit();

                return true;
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return false;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return false;
    }
}

function modifyReservationStatus($sn, $status_sn) {
    if (is_numeric($sn) and $sn >= 0
        and is_numeric($status_sn) and $status_sn >= 0 and $status_sn <= 3) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "UPDATE crs_reservation SET status_sn = :status_sn WHERE sn = :sn;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":sn", $sn);
                $sth->bindParam(":status_sn", $status_sn);
                $sth->execute();
                $dbh->commit();

                return true;
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return false;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return false;
    }
}

function deleteReservation($sn) {
    if (is_numeric($sn) and $sn >= 0) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "UPDATE crs_reservation SET is_deleted = TRUE WHERE sn = :sn;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":sn", $sn);
                $sth->execute();
                $dbh->commit();

                return true;
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return false;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return false;
    }
}

function searchAllReservation() {
    $dbh = connectDB();
    if (isset($dbh)) {
        try {
            $dbh->beginTransaction();
            $sql = "SELECT sn, status_sn, member_id, equipment_sn, start_datetime, end_datetime, memo, register_datetime FROM crs_reservation WHERE is_deleted = FALSE;";
            $sth = $dbh->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_CLASS, "Reservation");
            $sth->execute();
            $dbh->commit();

            return $sth->fetchAll();
        } catch (Exception $e) {
            $dbh->rollback();
            alertFail($e->getMessage());

            return null;
        } finally {
            disconnectDB($dbh);
        }
    }
}

function searchAllReservationMember($member_id) {
    $member_id = clearSpecialChar($member_id);
    if (strlen($member_id) > 0 and strlen($member_id) <= 80) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "SELECT sn, status_sn, member_id, equipment_sn, start_datetime, end_datetime, memo, register_datetime FROM crs_reservation WHERE is_deleted = FALSE AND member_id = :member_id;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":member_id", $member_id);
                $sth->setFetchMode(PDO::FETCH_CLASS, "Reservation");
                $sth->execute();
                $dbh->commit();

                return $sth->fetchAll();
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return null;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");
        return null;
    }
}

function searchReservation($sn) {
    if (is_numeric($sn) and $sn >= 0) {
        $dbh = connectDB();
        if (isset($dbh)) {
            try {
                $dbh->beginTransaction();
                $sql = "SELECT sn, status_sn, member_id, equipment_sn, start_datetime, end_datetime, memo, register_datetime FROM crs_reservation WHERE is_deleted = FALSE AND sn = :sn;";
                $sth = $dbh->prepare($sql);
                $sth->bindParam(":sn", $sn);
                $sth->setFetchMode(PDO::FETCH_CLASS, "Reservation");
                $sth->execute();
                $dbh->commit();

                return $sth->fetch();
            } catch (Exception $e) {
                $dbh->rollback();
                alertFail($e->getMessage());

                return null;
            } finally {
                disconnectDB($dbh);
            }
        }
    } else {
        alertFail("Parameters contained invalid values.");

        return null;
    }
}