<?php

namespace AtumSystems\PointClickCare\Resources;


class Facilities extends Resource
{
    /**
     * Get all Facilities
     * 
     * Retrieve a list of all facilities within an organization. 
     * The response includes a list of facilities including facility details.
     * 
     * https://amplify.pointclickcare.com/apiDocumentationAlone#operation/GETFacilities
     *
     * @param array $params
     * @return void
     */
    public function all(array $params = [])
    {
        return collect($this->client->request(
            'get', 
            '/facs',
            [],
            http_build_query($params)
        )->data);
    }

    /** 
     * Get information about a specific facility within an organization.
     * 
     * https://amplify.pointclickcare.com/apiDocumentationAlone#operation/GETFacility
     * 
     * @param integer $id 
     * */
    public function find($facilityId)
    {
        return json_encode($this->client->request(
            'get',
            '/facs/'.$facilityId
        )->data);
    }
}