<?php
namespace App\Http\Controllers;

/**
 * @SWG\Swagger(
 * basePath="/api/v1",
 * host="pmuniversity.co",
 * schemes={"http"},
 * produces={"application/json"},
 * @SWG\Info(
 * title="Prouct Management University APIs",
 * description="PMU api calls in the swagger-2.0 specification",
 * termsOfService="http://pmuniversity.co/terms/",
 * version="1.0.0",
 * @SWG\Contact(name="PMU API Team", url="http://pmuniversity.co/"),
 * ),
 * @SWG\ExternalDocumentation(
 * description="Find out more about Swagger",
 * url="http://swagger.io"
 * ),
 * @SWG\Tag(
 * name="Auth",
 * description="Operations about Authentication"
 * ),
 * @SWG\Definition(
 * definition="ValidationError",
 * required={"field", "message"},
 * type="object",
 * @SWG\Property(
 * property="field",
 * type="string"
 * ),
 * @SWG\Property(
 * property="message",
 * type="string"
 * )
 * ),
 * @SWG\Definition(
 * definition="responseModel",
 * type="object",
 * required={"httpCode", "success","message"},
 * @SWG\Property(
 * property="httpCode",
 * type="integer",
 * format="int32"
 * ),
 * @SWG\Property(
 * property="success",
 * type="boolean"
 * ),
 * @SWG\Property(
 * property="message",
 * type="string"
 * )
 * ),
 * @SWG\Definition(
 * definition="validationErrorModel",
 * type="object",
 * allOf={
 * @SWG\Schema(
 * ref="#definitions/responseModel"
 * ),
 * @SWG\Schema(
 * required={"data"},
 * @SWG\Property(
 * property="data",
 * type="array",
 * @SWG\Items(ref="#/definitions/ValidationError")
 * )
 * )
 * }
 * ),
 * @SWG\Definition(
 * definition="Pagination",
 * required={"total", "hasMore"},
 * type="object",
 * @SWG\Property(
 * property="total",
 * type="integer",
 * format="int64"
 * ),
 * @SWG\Property(
 * property="currentPage",
 * type="integer",
 * format="int64"
 * ),
 * @SWG\Property(
 * property="perPage",
 * type="integer",
 * format="int64"
 * ),
 * @SWG\Property(
 * property="lastPage",
 * type="integer",
 * format="int64",
 * description="Last page number",
 * ),
 * @SWG\Property(
 * property="hasMore",
 * description="Indicates still more pages are there?",
 * type="boolean"
 * ),
 * @SWG\Property(
 * property="nextPageUrl",
 * description="Next page URL",
 * type="string"
 * ),
 * @SWG\Property(
 * property="previousPageUrl",
 * description="Previous page URL",
 * type="string"
 * ),
 * @SWG\Property(
 * property="url",
 * description="Current page URL",*
 * type="string"
 * ),
 * ),
 * @SWG\Definition(
 * definition="rateLimit",
 * type="object",
 * @SWG\Header(
 * header="X-RateLimit-Limit",
 * type="integer",
 * format="int32",
 * description="Calls per minute allowed by the user"
 * ),
 * @SWG\Header(
 * header="X-RateLimit-Remaining",
 * type="integer",
 * format="int32",
 * description="The number of requests left for the time window"
 * ),
 * @SWG\Header(
 * header="Retry-After",
 * type="integer",
 * format="int32",
 * description="The number of minutes the user may request again"
 * ),
 * )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
}