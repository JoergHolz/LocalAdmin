<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 06.02.2016
 * Time: 19:39
 */

$this->load->library('user_agent');

echo "<div class='navbar navbar-default navbar-fixed-top'>
      <div class='container'>
        <div class='navbar-header'>";

echo "<a href='/' class='navbar-brand'>" . $logo . $title . "</a>";

echo "<button class='navbar-toggle' type='button' data-toggle='collapse' data-target='#navbar-main'>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </button>
        </div>
        <div class='navbar-collapse collapse' id='navbar-main'>
          <ul class='nav navbar-nav'>";

if (!empty($links)) {
    foreach ($links AS $v) {
        echo "<li>";

        if (empty($v["dropdown"])) {
            if (empty($v["target"])) {
                $v["target"] = "_blank";
            }
            echo "<a href = '" . $v["url"] . "' target = '" . $v["target"] . "'>" . $v["name"] . "</a >";
        } else {
            echo "<li class='dropdown'>
              <a class='dropdown-toggle' data-toggle='dropdown' href='#' aria-expanded='false'>" . $v["name"] . " <span class='caret'></span></a>
              <ul class='dropdown-menu' aria-labelledby='download'>";
            foreach ($v["dropdown"] AS $drop) {
                if (empty($drop["target"])) {
                    $drop["target"] = "_blank";
                }
                echo "<li><a href='" . $drop["url"] . "' target = '" . $drop["target"] . "'>" . $drop["name"] . "</a></li>";
                if (!empty($drop["divider"]) AND $drop["divider"] === TRUE) {
                    echo "<li class='divider'></li>";
                }
            }
            echo "</ul>
            </li>";
        }
        echo "</li>";
    }
}

echo "</ul>
      <ul class='nav navbar-nav navbar-right'>";

echo $local_ip;

echo $public_ip;

echo "<li><a data-toggle='popover' data-placement='bottom' title='' data-content='<small>Platform: </small>" . $this->agent->platform() . "<br><small>Browser: </small>" . $this->agent->browser() . "'><span class='glyphicon glyphicon-info-sign'></span></a></li>";

echo "</ul>
        </div>
      </div>
    </div>";
