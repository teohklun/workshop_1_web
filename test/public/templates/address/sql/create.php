<?php 
        $newAddress = array(
            "City"  => $input['City'],
            "State"  => $input['State'],
            "Postcode"  => $input['Postcode'],
            "Street"  => $input['Street']
        );

        $sql = getSqlInsertQueryString('address', $newAddress);
        $statement = $connection->prepare($sql);
        $statement->execute($newAddress);
        $addressID = $connection->lastInsertId();