<?php

namespace App\Manager;

use App\Helper\Common;
use Exception;

class ProductManager extends AbstractManager
{
    private const DECIMAL_AMOUNT = 1;
    private const MIN_VALUE = 0;
    private const MAX_VALUE = 10;

    public function getTopTen(): array
    {
        $products = [];

        try {
            $response = $this->client->request(
                "GET",
                "https://file.notion.so/f/f/5f4961f1-3ce8-4cbb-9a67-ec3baf081ee7/1ed10d1f-fd07-4cfd-9c23-35d3d765ffd5/amazon.json?id=209989fc-c7d2-45fe-8a29-bd2b16667532&table=block&spaceId=5f4961f1-3ce8-4cbb-9a67-ec3baf081ee7&expirationTimestamp=1719921600000&signature=eBdBvHg-LJScpuaay_9EQ_OAo2GMN4xly1ZP6935RKA&downloadName=amazon.json"
            );

            $content = $response->toArray();
            $products = $this->cleanProductData($content["SearchResult"]["Items"]);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $products;
    }

    private function cleanProductData(array $products): array
    {
        $data = [];
        foreach ($products as $product) {
            $itemInfo = $product["ItemInfo"] ?? null;
            $data[] = [
                "rank" => $product["BrowseNodeInfo"]["BrowseNodes"][0]["SalesRank"] ?? null,
                "title" => $itemInfo["Title"]["DisplayValue"] ?? null,
                "brand" => $itemInfo["ByLineInfo"]["Brand"]["DisplayValue"] ?? null,
                "saving" => $product["Offers"]["Listings"][0]["Price"]["Savings"]["Percentage"] ?? null,
                "detail_page" => $product["DetailPageURL"] ?? null,
                "image" => $product["Images"]["Primary"]["Large"]["URL"] ?? null,
                "descriptions" => $itemInfo["Features"]["DisplayValues"] ?? null,
                "score_data" => $this->getScoreData()
            ];
        }

        return $data;
    }

    private function getScoreData(): array
    {
        $score = Common::getRandomFloat(self::DECIMAL_AMOUNT, self::MIN_VALUE, self::MAX_VALUE);
        $percentage = $this->getScorePecentage($score);

        return [
            "score" => $score,
            "percentage" => $percentage,
            "text" => $this->getScoreText($percentage)
        ];
    }

    private function getScorePecentage(float $score): int
    {
        return ($score / self::MAX_VALUE) * 100;
    }

    private function getScoreText(int $percentage): string
    {
        $text = "Deficiente";
        $ranges = [
            [
                "value" => 0,
                "message" => "Deficiente"
            ],
            [
                "value" => 50,
                "message" => "Aceptable"
            ],
            [
                "value" => 60,
                "message" => "Bueno"
            ],
            [
                "value" => 70,
                "message" => "Genial"
            ],
            [
                "value" => 80,
                "message" => "Excelente"
            ],
            [
                "value" => 90,
                "message" => "Excepcional"
            ],
            [
                "value" => 100,
                "message" => ""
            ]
        ];

        for ($i = 0; $i < count($ranges) - 1; $i++) {
            if ($percentage > $ranges[$i]["value"] && $percentage <= $ranges[$i + 1]["value"]) {
                $text = $ranges[$i]["message"];
            }
        }

        return $text;
    }
}
