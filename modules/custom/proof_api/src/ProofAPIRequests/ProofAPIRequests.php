<?php

/*
Make all requests to Proof API
*/

namespace Drupal\proof_api\ProofAPIRequests;

class ProofAPIRequests
{
    public function listAllMovies()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://proofapi.herokuapp.com/videos?page&per_page');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'X-Auth-Token: kFDTf2t7HVfA24Red68sE31K'
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($response, true);
        $dataArray = $json['data'];
        $createdAt = array();

        foreach ($dataArray as $movie) {
            $createdAt[] = $movie['attributes']['created_at'];
        }

        array_multisort($createdAt, SORT_DESC, $dataArray);

        print "<table>";

            for ($i = 0; $i < count($dataArray); $i++) {

                print "<tr><td><a href='" . $dataArray[$i]['attributes']['url'] . "'>" . $dataArray[$i]['attributes']['title'] . "</td>";
            }

            print "</table>";
    }

    public function listTopTenByViews()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://proofapi.herokuapp.com/videos?page&per_page');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Auth-Token: kFDTf2t7HVfA24Red68sE31K'
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($response, true);
        $dataArray = $json['data'];
        $viewTally = array();

        foreach ($dataArray as $movie) {
            $viewTally[] = $movie['attributes']['view_tally'];
        }

        array_multisort($viewTally, SORT_DESC, $dataArray);

        print "<table>";

        for ($i = 0; $i < 4; $i++) {

            print "<tr><td>" . ($i + 1) . ")</td><td>" . "<a href='" . $dataArray[$i]['attributes']['url'] . "'>" . $dataArray[$i]['attributes']['title'] . "</td><td>" . $dataArray[$i]['attributes']['view_tally'] . " views</td>";
        }

        print "</table>";
    }

    public function listTopTenByVotes()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://proofapi.herokuapp.com/videos?page&per_page');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Auth-Token: kFDTf2t7HVfA24Red68sE31K'
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($response, true);
        $dataArray = $json['data'];
        $voteTally = array();

        foreach ($dataArray as $movie) {
            $voteTally[] = $movie['attributes']['vote_tally'];
        }

        array_multisort($voteTally, SORT_DESC, $dataArray);

        print "<table>";

        for ($i = 0; $i < count($dataArray) && $i < 10; $i++) {

            print "<tr><td>" . ($i + 1) . ")</td><td>" . "<a href='" . $dataArray[$i]['attributes']['url'] . "'>" . $dataArray[$i]['attributes']['title'] . "</td><td>" . $dataArray[$i]['attributes']['vote_tally'] . " votes</td>";
        }

        print "</table>";
    }

    public function postNewMovie($title, $url, $slug)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://proofapi.herokuapp.com/videos");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"title\": \"{$title}\",
            \"url\": \"{$url}\",
            \"slug\": \"{$slug}\"
        }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "X-Auth-Token: kFDTf2t7HVfA24Red68sE31K"
        ));

        curl_exec($ch);
        curl_close($ch);
    }
}

