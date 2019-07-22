<?php

declare(strict_types=1);

namespace Rebing\GraphQL\Tests\Database\SelectFields\ParentIdTests;

use Closure;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Tests\Support\Models\Post;

class ParentIdQuery extends Query
{
    protected $attributes = [
        'name' => 'parentIdQuery',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Post'));
    }

    public function resolve($root, $args, $ctx, ResolveInfo $info, Closure $getSelectFields)
    {
        /** @var SelectFields $selectFields */
        $selectFields = $getSelectFields();

        return Post
            ::with($selectFields->getRelations())
            ->select($selectFields->getSelect())
            ->get();
    }
}