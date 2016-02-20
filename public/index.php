<?php
  require_once("socrata.php");

  //$view_uid = "h8x4-nvyi";
  /*<td><a href="https://www.google.com/maps/search/<?= $row["location"]["coordinates"][1] ?>,<?= $row["location"]["coordinates"][0] ?>"><?= $row["address"] ?></a></td>
  */
  //https://data.sfgov.org/resource/tkzw-k3nq.json
  //$response == NULL
  $view_uid = "tkzw-k3nq";
  $root_url = "data.sfgov.org";
  $app_token = "swtYmOjaeAOAuQ0UXBuOkQtWb";
  $response = NULL;

  $latitude = array_get("latitude", $_POST);
  $longitude = array_get("longitude", $_POST);
  $range = array_get("range", $_POST);

  $postBack = $_SERVER['REQUEST_METHOD'] == 'POST';

  if ($postBack)
  {

    if($latitude != NULL && $longitude != NULL && $range != NULL) {
      // Create a new unauthenticated client
      $socrata = new Socrata($root_url, $app_token);

      $params = array("\$where" => "within_circle(location, $latitude, $longitude, $range)");
      $response = $socrata->get($view_uid, $params);
    }

  }
?>
<html>
  <head>
    <title>San Francisco Trees</title>
  </head>
  <body>
    <h1>San Francisco Trees</h1>

    <p>If you get no results, its likely because there are no trees at that location. Try another lat/long.</p>

    <?php if(!$postBack) { ?>
      <form action="index.php" method="POST">
        <label for="latitude">Latitude</label>
        <input type="text" name="latitude" size="10" value="37.790842"/><br/>

        <label for="longitude">Longitude</label>
        <input type="text" name="longitude" size="10" value="-122.426111"/><br/>

        <label for="range">Range</label>
        <input type="text" name="range" size="10" value="10000"/><br/>

        <input type="submit" value="Submit"/>
      </form>
    <?php } else { ?>
      <h2>Results</h2>

      <?# Create a table for our actual data ?>
      <table border="1">
        <tr>
          <th>Description</th>
          <th>Address</th>
        </tr>
        <?# Print rows ?>
        <?php foreach($response as $row) { ?>
          <tr>
            <td><?= $row["qSpecies"] ?></td>
            <td><a href="https://www.google.com/maps/search/<?= $row["Latitude"] ?>,<?= $row["Longitude"] ?>"><?= $row["qAddress"] ?></a></td>
          </tr>
        <?php } ?>
      </table>

      <h3>Raw Response</h3>
      <pre><?= var_dump($response) ?></pre>
    <?php } ?>
  </body>
</html>

