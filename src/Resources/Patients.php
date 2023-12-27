<?php

namespace AtumSystems\PointClickCare\Resources;

use Illuminate\Support\Arr;

class Patients extends Resource {

    /**
     * A collection of patients for the provided facilityId
     *
     * @param int $facilityId
     * @param array $params
     * @return void
     */
    public function allByFacilityId(int $facilityId, $params = [])
    {
        return collect($this->byFacilityId($facilityId, $params));
    }

    /**
     * Retrieve a list of all patients within a certain facility. 
     * The response includes a list of patients including their demographics and other details.
     * 
     * https://amplify.pointclickcare.com/apiDocumentationAlone#operation/GETPatients
     *
     * @param integer $facilityId
     * @return void
     */
    public function byFacilityId(int $facilityId, $params = [])
    {
        $patients = [];
        $params['facId'] = $facilityId;
        $params['pageSize'] = 200;

        $response =  $this->client->request(
            'get', 
            'patients',
            [],
            (http_build_query($params))
        );

        array_push($patients, $response->data->data);

        while ($response->data->paging->hasMore === true) {
            $params['page'] = $response->data->paging->page + 1;
            $response =  $this->client->request(
                'get', 
                'patients',
                [],
                (http_build_query($params))
            );

            array_push($patients, $response->data->data);
        }


        return Arr::flatten($patients);
    }

    /**
     * Get information about a specific patient. 
     * The response includes patient demographics and other details about the patient.
     * 
     * https://amplify.pointclickcare.com/apiDocumentationAlone#operation/GETPatient
     * 
     * A patient ID is specific to each facility.
     *
     * @param integer $patientId
     * @return void
     */
    public function find(int $patientId, $params = [])
    {
        return $this->client->request(
            'get',
            'patients/'.$patientId,
            [],
            (http_build_query($params))
        )->data;
    }
}