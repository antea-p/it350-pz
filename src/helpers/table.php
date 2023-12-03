<?php

function create_table($headers, $rows, $idFieldName = 'id', $delete = null, $details=null, $details_url=null) {
    echo "<table>";
    echo "<tr>";
    foreach ($headers as $header) {
        echo "<th>$header</th>";
    }
    if (!is_null($delete)) {
        echo "<th></th>";
    }
    if (!is_null($details)) {
        echo "<th></th>";
    }
    echo "</tr>";
    foreach ($rows as $row) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>$cell</td>";
        }
        if (!is_null($delete)) {
            echo "<td><form method='post'><input name='$idFieldName' type='hidden' value='$row[$idFieldName]'><input type='submit' name='submit' value='$delete'></form></td>";
        }
        if (!is_null($details)) {
            echo "<td><a href='$details_url?id=$row[id]'>$details</a></td>";
        }
        echo "</tr>";
    }
    echo "</table>";

}