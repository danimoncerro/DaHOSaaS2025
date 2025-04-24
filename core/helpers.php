<?php

function view_path(string $path): string
{
    return dirname(__DIR__) . "/app/views/" . $path . ".php";
}
