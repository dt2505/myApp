<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use SecretBase\AppBundle\Services\Util\TokenGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class DetailController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getDetailAction(Request $request)
    {
        return $this->render("AppBundle::detail.html.twig", array(
            "detail" => $this->getDetails()
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getEmptyItemAction(Request $request)
    {
        $itemId = $request->query->get("itemId");
        $itemType = $request->query->get("itemType");
        $itemTemplate = $request->query->get("itemTemplate");

        $tokenGenerator = new TokenGenerator();
        if ($itemData = $this->getItemData($itemId)) {

            switch($itemType) {
                case "service":
                    $itemData = $this->getItemData($itemId, $tokenGenerator->generate(8));
                    break;
                case "option":
                    $itemData = $this->getOptionItemData("new", $tokenGenerator->generate(8));
                    break;
            }

            return $this->render("AppBundle:widgets:unit-price.html.twig", array(
                "unitPriceItem" => $itemData,
                "unitPricePrefix" => $itemType . '-' . $itemId
            ));
        } else {
            return new JsonResponse(["empty" => true], Response::HTTP_EXPECTATION_FAILED);
        }
    }

    /**
     * @param Request $request
     * @Rest\Delete()
     * @return Response
     */
    public function removeItemAction(Request $request)
    {
        $itemId = $request->get("itemId");
        $itemType = $request->get("itemType");
        $subitems = $request->get("subitems");

        return new Response(json_encode(["success" => true]));
    }

    /**
     * @param Request $request
     * @Rest\Post()
     * @return Response
     */
    public function saveCalendarAction (Request $request)
    {
        return new JsonResponse($request->request->get("data"));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCalendarEventsAction(Request $request)
    {
        return new JsonResponse($this->getCalendarEvents());
    }

    /**
     * @param $name
     * @param int $id
     * @param bool $checked
     * @param int $unitValue
     * @param string $selectedUnit
     * @param int $price
     * @param string $selectedCurrency
     * @param string $desc
     * @return mixed
     */
    private function getItemData($name, $id = 1, $checked = false, $unitValue = 1, $selectedUnit = "h", $price = 0, $selectedCurrency = "1", $desc = "")
    {
        $incallItemData = [
            "id" => $id,
            "checked" => $checked,
            "template" => "unit-price",
            "hasUnit" => true,
            "unit" => [
                "value" => $unitValue,
                "min" => 1,
                "selected" => $selectedUnit,
                "options" => $this->getUnitOptions()
            ],
            "price" => [
                "value" => $price,
                "currency" => [
                    "selected" => $selectedCurrency,
                    "options" => $this->getCurrencyOptions()
                ]
            ],
            "hasDesc" => false
        ];
        $outcallItemData = [
            "id" => $id,
            "checked" => $checked,
            "template" => "unit-price",
            "hasUnit" => true,
            "unit" => [
                "value" => $unitValue,
                "min" => 1,
                "selected" => $selectedUnit,
                "options" => $this->getUnitOptions()
            ],
            "price" => [
                "value" => $price,
                "currency" => [
                    "selected" => $selectedCurrency,
                    "options" => $this->getCurrencyOptions()
                ]
            ],
            "hasDesc" => false
        ];
        $overnightItemData = [
            "id" => $id,
            "checked" => $checked,
            "template" => "unit-price",
            "hasUnit" => false,
            "price" => [
                "value" => $price,
                "currency" => [
                    "selected" => $selectedCurrency,
                    "options" => $this->getCurrencyOptions()
                ]
            ],
            "hasDesc" => true,
            "desc" => [
                "rows" => 4,
                "text" => $desc
            ]
        ];
        $escortItemData = [
            "id" => $id,
            "checked" => $checked,
            "template" => "unit-price",
            "hasUnit" => true,
            "unit" => [
                "value" => $unitValue,
                "min" => 1,
                "selected" => $selectedUnit,
                "options" => $this->getUnitOptions()
            ],
            "price" => [
                "value" => $price,
                "currency" => [
                    "selected" => $selectedCurrency,
                    "options" => $this->getCurrencyOptions()
                ]
            ],
            "hasDesc" => true,
            "desc" => [
                "rows" => 4,
                "text" => $desc
            ]
        ];
        $suanaItemData = [
            "id" => $id,
            "checked" => $checked,
            "template" => "unit-price",
            "hasUnit" => true,
            "unit" => [
                "value" => $unitValue,
                "min" => 1,
                "selected" => $selectedUnit,
                "options" => $this->getUnitOptions()
            ],
            "price" => [
                "value" => $price,
                "currency" => [
                    "selected" => $selectedCurrency,
                    "options" => $this->getCurrencyOptions()
                ]
            ],
            "hasDesc" => true,
            "desc" => [
                "rows" => 4,
                "text" => $desc
            ]
        ];
        $itemData = [
            1 => $incallItemData,
            2 => $overnightItemData,
            3 => $outcallItemData,
            4 => $escortItemData,
            5 => $suanaItemData
        ];

        return $itemData[$name];
    }

    private function getUnitOptions()
    {
        return [
            ["id" => 'm', "name" => "Minute"],
            ["id" => 'h', "name" => "Hour"],
        ];
    }

    private function getCurrencyOptions()
    {
        return [
            ["id" => 1, "symbol" => "$", "shortName" =>"AUD", "fullName"=>"Australia Dollar"],
            ["id" => 2, "symbol" => "¥", "shortName" =>"CNY", "fullName"=>"Chinese Yuan"],
            ["id" => 3, "symbol" => "$", "shortName" =>"USD", "fullName"=>"American Dollar"],
            ["id" => 4, "symbol" => "€", "shortName" =>"EUR", "fullName"=>"European Dollar"],
        ];
    }

    private function getDetails($empty = false)
    {
        $tokenGenerator = new TokenGenerator();
        $id = $tokenGenerator->generate(8);
        return [
            "id" => $id,
            "calendarEventsEndpoint" => $this->generateUrl("get_calendar_events", array("objectId" => $id)),
            "media" => $this->getMedia(),
            "groups" => $this->getGroup($empty),
            "targetClients" => $this->getTargetClients(),
            "services" => $this->getServices($empty),
            "options" => $this->getOptions($empty),
        ];
    }

    private function getMedia()
    {
        return [
            "album" => [
                "id" => 1,
                "name" => "Album one",
                "photos_count" => 12,
                "photos" => [
                    ["id" => 1, "url" => "img/alila/01.jpg", "thumbnail" => "img/alila/thumb-01.jpg"],
                    ["id" => 2, "url" => "img/alila/02.jpg", "thumbnail" => "img/alila/thumb-02.jpg"],
                    ["id" => 3, "url" => "img/alila/03.jpg", "thumbnail" => "img/alila/thumb-03.jpg"],
                    ["id" => 4, "url" => "img/alila/04.jpg", "thumbnail" => "img/alila/thumb-04.jpg"],
                    ["id" => 5, "url" => "img/alila/05.jpg", "thumbnail" => "img/alila/thumb-05.jpg"],                    ["id" => 6, "url" => "img/alila/06.jpg", "thumbnail" => "img/alila/thumb-06.jpg"],
                    ["id" => 6, "url" => "img/alila/07.jpg", "thumbnail" => "img/alila/thumb-06.jpg"],
                    ["id" => 7, "url" => "img/alila/08.jpg", "thumbnail" => "img/alila/thumb-07.jpg"],
                    ["id" => 8, "url" => "img/alila/09.jpg", "thumbnail" => "img/alila/thumb-08.jpg"],
                    ["id" => 9, "url" => "img/alila/10.jpg", "thumbnail" => "img/alila/thumb-09.jpg"],
                    ["id" => 10, "url" => "img/alila/11.jpg", "thumbnail" => "img/alila/thumb-10.jpg"],
                    ["id" => 11, "url" => "img/alila/12.jpg", "thumbnail" => "img/alila/thumb-11.jpg"],
                    ["id" => 12, "url" => "img/alila/12.jpg", "thumbnail" => "img/alila/thumb-12.jpg"],
                ]
            ]
        ];
    }

    private function getGroup($empty = false)
    {
        if ($empty) {
            return [];
        }

        return [
            ["id" => 1, "name" => "Model", "isDefault" => true],
            ["id" => 2, "name" => "Office Lady", "isDefault" => false],
            ["id" => 3, "name" => "Student", "isDefault" => false],
            ["id" => 4, "name" => "G-CUP", "isDefault" => false],
        ];
    }

    private function getServices($empty = false)
    {
        if ($empty) {
            return [
                [
                    "id" => 1,
                    "displayName" => "In-call",
                    "checked" => true,
                    "template" => "unit-price",
                    "items" => []
                ],
                [
                    "id" => 2,
                    "displayName" => "Overnight",
                    "checked" => false,
                    "template" => "unit-price",
                    "items" => []
                ],
                [
                    "id" => 3,
                    "displayName" => "Out-call",
                    "checked" => false,
                    "template" => "unit-price",
                    "items" => []
                ],
                [
                    "id" => 4,
                    "displayName" => "Escort",
                    "checked" => false,
                    "template" => "unit-price",
                    "items" => []
                ],
                [
                    "id" => 5,
                    "displayName" => "Suana",
                    "checked" => false,
                    "template" => "unit-price",
                    "items" => []
                ],
            ];
        }

        return [
            [
                "id" => 1,
                "displayName" => "In-call",
                "checked" => true,
                "template" => "unit-price",
                "items" => [
                    $this->getItemData(1, 1, true, 2, "h", "570", 1),
                    $this->getItemData(1, 2, false, 1, "h", "270", 2),
                    $this->getItemData(1, 3, false, 45, "m", "170", 1)
                ]
            ],
            [
                "id" => 2,
                "displayName" => "Overnight",
                "checked" => false,
                "template" => "unit-price",
                "items" => [
                    $this->getItemData(2, 1, true, null, null, "2000", 1, "Don't miss out this girl, she is freaking hot and skilled")
                ]
            ],
            [
                "id" => 3,
                "displayName" => "Out-call",
                "checked" => false,
                "template" => "unit-price",
                "items" => []
            ],
            [
                "id" => 4,
                "displayName" => "Escort",
                "checked" => false,
                "template" => "unit-price",
                "items" => [
                    $this->getItemData(4, 1, true, 2, "h", "570", 1, "Escort detail goes here."),
                ]
            ],
            [
                "id" => 5,
                "displayName" => "Suana",
                "checked" => false,
                "template" => "unit-price",
                "items" => []
            ],
        ];
    }

    private function getOptions($empty = false)
    {
        if ($empty) {
            return [];
        }

        return [
            [
                "id" => 1,
                "displayName" => "SM",
                "checked" => true,
                "template" => "unit-price",
                "items" => [
                    $this->getOptionItemData("handcuffs"),
                    $this->getOptionItemData("setmouthsbead"),
                ]
            ],
            [
                "id" => 2,
                "displayName" => "Uniform",
                "checked" => true,
                "template" => "unit-price",
                "items" => []
            ],
        ];
    }

    private function getOptionItemData($name, $newId = null)
    {
        $records = [
            "handcuffs" => ["id" => 1, "name" => "handcuffs", "labelName" => "Handcuffs", "price" => 20, "selectedCurrency" => 1, "checked" => true, "template" => "unit-price"],
            "setmouthsbead" => ["id" => 2, "name" => "setmouthsbead", "labelName" => "Set Mouths Bead", "price" => 20, "selectedCurrency" => 1, "checked" => false, "template" => "unit-price"],
        ];

        if (!array_key_exists($name, $records)) {
            return [
                "id" => $newId,
                "labelName" => "",
                "hasLabel" => true,
                "checked" => false,
                "template" => "unit-price",
                "price" => [
                    "value" => 0,
                    "currency" => [
                        "selected" => 1,
                        "options" => $this->getCurrencyOptions()
                    ]
                ]
            ];
        }

        $itemDetail = $records[$name];
        return [
            "id" => $itemDetail["id"],
            "labelName" => $itemDetail["labelName"],
            "hasLabel" => true,
            "checked" => $itemDetail["checked"],
            "template" => $itemDetail["template"],
            "price" => [
                "value" => $itemDetail["price"],
                "currency" => [
                    "selected" => $itemDetail["selectedCurrency"],
                    "options" => $this->getCurrencyOptions()
                ]
            ]
        ];
    }

    private function getCalendarEvents()
    {
        return [
            [
                "title" => 'Happy Hour',
                "start" => '2015-04-06',
                "end" => '2015-04-07',
                "className" => 'purple'
            ],
            [
                "title" => 'Birthday Party',
                "start" => '2015-01-15',
                "end" => '2015-01-17',
                "className" =>  'mint'
            ],
            [
                "title" =>  'All Day Event',
                "start" =>  '2015-01-15',
                "className" =>  'warning'
            ],
            [
                "title" =>  'Meeting',
                "start" =>  '2015-04-07T10:30:00',
                "end" =>  '2015-04-08T12:30:00',
                "className" =>  'danger'
            ],
            [
                "title" =>  'All Day Event',
                "start" =>  '2015-02-01',
                "className" =>  'warning'
            ],
            [
                "title" =>  'Long Event',
                "start" =>  '2015-02-07',
                "end" =>  '2015-02-10',
                "className" =>  'purple'
            ],
            [
                "id" => 999,
                "title" =>  'Repeating Event',
                "start" =>  '2015-02-09T16:00:00'
            ],
            [
                "id" => 999,
                "title" =>  'Repeating Event',
                "start" =>  '2015-02-16T16:00:00',
                "className" =>  'success'
            ],
            [
                "title" =>  'Conference',
                "start" =>  '2015-02-11',
                "end" =>  '2015-02-13',
                "className" =>  'dark'
            ],
            [
                "title" =>  'Meeting',
                "start" =>  '2015-02-12T10:30:00',
                "end" =>  '2015-02-12T12:30:00'
            ],
            [
                "title" =>  'Lunch',
                "start" =>  '2015-02-12T12:00:00',
                "className" =>  'pink'
            ],
            [
                "title" =>  'Meeting',
                "start" =>  '2015-02-12T14:30:00',
                "color: "#333333"
            ],
            [
                "title" =>  'Happy Hour',
                "start" =>  '2015-02-12T17:30:00'
            ],
            [
                "title" =>  'Dinner',
                "start" =>  '2015-02-12T20:00:00'
            ],
            [
                "title" =>  'Birthday Party',
                "start" =>  '2015-02-13T07:00:00'
            ],
            [
                "title" =>  'Click for Google',
                "url" =>  'http://google.com/',
                "start" =>  '2015-02-28'
            ]
        ];
    }

    private function getTargetClients()
    {
        return [
            ["id" => 1, "name" => "Any", "selected" => false],
            ["id" => 2, "name" => "Chinese", "selected" => true],
            ["id" => 3, "name" => "Local", "selected" => false],
            ["id" => 4, "name" => "European", "selected" => false],
            ["id" => 5, "name" => "American", "selected" => false],
            ["id" => 6, "name" => "African", "selected" => false],
            ["id" => 7, "name" => "Japanese", "selected" => true],
            ["id" => 8, "name" => "Korean", "selected" => true],
        ];
    }
}
