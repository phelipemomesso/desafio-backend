<?php

/**
 * @OA\Parameter(
 *     parameter="base_search",
 *     name="search",
 *     in="query",
 *     description="Search parameter to filter results, you can optionally specify the columns to filter, for example: column1: value1; column2: value2",
 *     required=false,
 *     @OA\Schema(
 *         type="string",
 *     )
 * )
 */

/**
 * @OA\Parameter(
 *     parameter="base_search_join",
 *     name="searchJoin",
 *     in="query",
 *     description="Join parameter to filter the search results",
 *     required=false,
 *     @OA\Schema(
 *         type="string",
 *         enum={"and", "or"},
 *     )
 * )
 */

/**
 * @OA\Parameter(
 *     parameter="base_sorted_by",
 *     name="sortedBy",
 *     in="query",
 *     description="Sort parameter to sort the results",
 *     required=false,
 *     @OA\Schema(
 *         type="string",
 *         enum={"asc", "desc"},
 *     )
 * )
 */
