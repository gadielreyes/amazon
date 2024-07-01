<?php

namespace App\Manager;

use Exception;

class ProductManager extends AbstractManager
{
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
            ];
        }

        return $data;
    }
}
