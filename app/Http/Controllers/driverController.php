<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Function to notify the customer the confirmation of their services, depending on their mobile platform
     * @param string service_id
     * @param string driver_id
     * @return Json
     */

    public function post_confirm()
    {
        $id = Input::get('service_id');
        $idDriver = Input::get('driver_id');
        $service = Service::find($id);

        if (!empty($service))
        {
            if ($service->status_id == '6')
            {
                return Response::json(array('error' => '2'));
            }

            if (empty($service->driver_id) && $service->status_id == '1')
            {
                $service = Service::update($id, array(
                    'driver_id' => $idDriver,
                    'status_id' => '2'
                ));
                Driver::update($idDriver, array(
                    'available' => '0'
                ));
                $driverTmp = Driver::find($idDriver);
                Service::update($id, array(
                    'car_id' => $driverTmp->car_id
                ));

                $service = Service::find($id);


                if (empty($service->user->uuid))
                {
                    return Response::json(array('error' => '0'));
                }

                $this->sendNotification($service);

                return Response::json(array('error' => '0'));
            } else
            {
                return Response::json(array('error' => '1'));
            }
        } else
        {
            return Response::json(array('error' => '3'));
        }
    }

    /**
     * Function to notify the customer the confirmation of their services, depending on their mobile platform
     * @param type $service
     *
     */
    public function sendNotification($service)
    {

        $pushMessage = 'Tu servicio ha sido confirmado';
        $push = Push::make();

        if ($service->user->type = '1') {
            $result = $push->ios($service->user->uuid, $pushMessage, 1, 'honk.wav', 'Open', array('serviceId' => $service->id));
        } else {
            $result = $push->android2($service->user->uuid, $pushMessage, 1, 'default', 'Open', array('serviceId' => $service->id));
        }
        return $result;
    }
}


