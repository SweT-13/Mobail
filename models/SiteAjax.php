<?php

class SiteAjax
{
    public static function getMaxId()
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT MAX(id) FROM events');
        $result = $result->fetch();
        $result = $result[0];
        return $result;
    }

    public static function getEvent()
    {
        $db = Db::getConnection();

        $result = $db->query("SELECT * FROM events");
        $list = "{";
        $i = 0;
        while ($row = $result->fetch()) {
            if ($i != 0){
                $list .= ',';
            }
            $list .= '"e'.$i.'":{ 
            "id": "'.$row['id'].'",
            "message":"'.$row['message'].'",
            "status": "'.$row['status'].'",
            "datetime": "'.$row['datecreate'].'"
            }';
            $i++;
        }
        $list .="}";

        return $list;
    }

    public static function addEvent($id, $message, $status, $date)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO  events (id, message, status, datecreate) '
            . 'VALUES (:id, :message, :status, :datecreate) ';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':message', $message, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_BOOL);
        $result->bindParam(':datecreate', $date, PDO::PARAM_STR);
        return $result->execute();
    }

    public static function updEvent($id, $status)
    {
        $db = Db::getConnection();

        $sql = 'UPDATE events SET status = :status WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function delEvent($id)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM events WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }
}