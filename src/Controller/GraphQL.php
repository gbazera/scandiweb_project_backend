<?php

namespace App\Controller;

use App\Core\Database;
use App\Types\CategoryType;
use App\Types\ProductType;
use App\Types\AttributeType;
use App\Types\Types;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Types\OrderType;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use GraphQL\Error\DebugFlag;
use RuntimeException;
use Throwable;

class GraphQL {
    static public function handle() {

        $db = Database::connect();

        try {

            $category_input_type = new InputObjectType([
                'name' => 'CategoryInput',
                'fields' => [
                    'name' => ['type' => Type::nonNull(Type::string())],
                ],
            ]);

            $order_item_input_type = new InputObjectType([
                'name' => 'OrderItemInput',
                'fields' => [
                    'product_id' => Type::nonNull(Type::string()),
                    'quantity' => Type::nonNull(Type::int()),
                    'price' => Type::nonNull(Type::float()),
                    'attributes' => Type::nonNull(Type::string())
                ],
            ]);

            $order_input_type = new InputObjectType([
                'name' => 'OrderInput',
                'fields' => [
                    'items' => Type::nonNull(Type::listOf($order_item_input_type)),
                    'total' => Type::nonNull(Type::float()),
                ],
            ]);

            $queryType = new ObjectType([
                'name' => 'Query',
                'fields' => [
                    'categories' => [
                        'type' => Type::listOf(Types::category()),
                        'resolve' => static fn() => Category::fetchAll($db)
                    ],
                    'category' => [
                        'type' => Types::category(),
                        'args' => [
                            'input' => $category_input_type
                        ],
                        'resolve' => static function($root, array $args) use ($db): ?array{
                            return Category::find($args['input']['name'], $db);
                        },
                    ],
                    'product' => [
                        'type' => Types::product(),
                        'args' => [
                            'id' => Type::nonNull(Type::string()),
                        ],
                        'resolve' => static function($root, array $args) use ($db): ?Product{
                            return Product::find($args['id'], $db);
                        }
                    ]
                ],
            ]);
        
            $mutationType = new ObjectType([
                'name' => 'Mutation',
                'fields' => [
                    'createOrder' => [
                        'type' => Types::order(),
                        'args' => [
                            'input' => Type::nonNull($order_input_type),
                        ],
                        'resolve' => static function($root, array $args) use ($db): array{
                            $items = $args['input']['items'];
                            $total = $args['input']['total'];
                            
                            $success = Order::create($items, $total, $db);

                            if($success){
                                return ['success' => true, 'message' => 'order placed successfully.'];
                            }

                            return ['success' => false, 'message' => 'failed to place order.'];
                        }
                    ]
                ], 
            ]);
        
            // See docs on schema options:
            // https://webonyx.github.io/graphql-php/schema-definition/#configuration-options
            $schema = new Schema(
                (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
            );
        
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }
        
            $input = json_decode($rawInput, true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;
        
            $rootValue = ['prefix' => 'You said: '];
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray(DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE);
        } catch (Throwable $e) {
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}