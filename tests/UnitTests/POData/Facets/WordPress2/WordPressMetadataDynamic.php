<?php

namespace UnitTests\POData\Facets\WordPress2;

use POData\Providers\Metadata\Type\EdmPrimitiveType;
use POData\Common\InvalidOperationException;
use POData\Providers\Metadata\IMetadataProvider;
use POData\Providers\Metadata\SimpleMetadataProvider;

class WordPressMetadataDynamic
{

    private static $_entityMapping = array();

    /**
     * create metadata.
     *
     * @throws InvalidOperationException
     *
     * @return IMetadataProvider
     */
    public static function create()
    {
        $metadata = new SimpleMetadataProvider('WordPressEntities', 'WordPress');

        $postEntity = new \POData\Providers\Metadata\Entity\Dynamic([
            //Key Edm.Int32
            'PostID' => [],
            //Edm.Int32
            'Author' => [],
            //Edm.DateTime
            'Date' => [],
            //Edm.DateTime
            'DateGmt' => [],
            //Edm.String
            'Content' => [],
            //Edm.String
            'Title' => [],
            //Edm.String
            'Excerpt' => [],
            //Edm.String
            'Status' => [],
            //Edm.String
            'CommentStatus' => [],
            //Edm.String
            'PingStatus' => [],
            //Edm.String
            'Password' => [],
            //Edm.String
            'Name' => [],
            //Edm.String
            'ToPing' => [],
            //Edm.String
            'Pinged' => [],
            //Edm.DateTime
            'Modified' => [],
            //Edm.DateTime
            'ModifiedGmt' => [],
            //Edm.String
            'ContentFiltered' => [],
            //Edm.Int32
            'ParentID' => [],
            //Edm.String
            'Guid' => [],
            //Edm.Int32
            'MenuOrder' => [],
            //Edm.String
            'Type' => [],
            //Edm.String
            'MimeType' => [],
            //Edm.Int32
            'CommentCount' => [],
            //Navigation Property User (ResourceReference)
            'User' => [],
            //Navigation Property tags (ResourceSetReference)
            'Tags' => [],
            //Navigation Property categories (ResourceSetReference)
            'Categories' => [],
            //Navigation Property comments (ResourceSetReference)
            'Comments' => [],
        ]);

        $tagEntity = new \POData\Providers\Metadata\Entity\Dynamic([
            //Key Edm.Int32
            'TagID' => [],
            //Edm.String
            'Name' => [],
            //Edm.String
            'Slug' => [],
            //Edm.String
            'Description' => [],
            //Navigation Property Posts (ResourceSetReference)
            'Posts' => [],
        ]);

        $categoryEntity = new \POData\Providers\Metadata\Entity\Dynamic([
            //Key Edm.Int32
            'CategoryID' => [],
            //Edm.String
            'Name' => [],
            //Edm.String
            'Slug' => [],
            //Edm.String
            'Description' => [],
            //Navigation Property Posts (ResourceSetReference)
            'Posts' => [],
        ]);

        $commentEntity = new \POData\Providers\Metadata\Entity\Dynamic([
            //Key Edm.Int32
            'CommentID' => [],
            //Edm.Int32
            'PostID' => [],
            //Edm.String
            'Author' => [],
            //Edm.String
            'AuthorEmail' => [],
            //Edm.String
            'AuthorUrl' => [],
            //Edm.String
            'AuthorIp' => [],
            //Edm.DateTime
            'Date' => [],
            //Edm.DateTime
            'DateGmt' => [],
            //Edm.String
            'Content' => [],
            //Edm.Int32
            'Karma' => [],
            //Edm.String
            'Approved' => [],
            //Edm.String
            'Agent' => [],
            //Edm.String
            'Type' => [],
            //Edm.Int32
            'ParentID' => [],
            //Edm.Int32
            'UserID' => [],
            //Navigation Property User (ResourceReference)
            'User' => [],
            //Navigation Property Post (ResourceReference)
            'Post' => [],
        ]);
        
        $userEntity = new \POData\Providers\Metadata\Entity\Dynamic([
            //Key Edm.Int32
            'UserID' => [],
            //Edm.String
            'Login' => [],
            //Edm.String
            'Nicename' => [],
            //Edm.String
            'Email' => [],
            //Edm.String
            'Url' => [],
            //Edm.DateTime
            'Registered' => [],
            //Edm.Int16
            'Status' => [],
            //Edm.String
            'DisplayName' => [],
            //Navigation Property Posts (ResourceSetReference)
            'Posts' => [],
            //Navigation Property Comments (ResourceSetReference)
            'Comments' => [],
        ]);    

        //Register the entity (resource) type 'Post'
        $postsEntityType = $metadata->addEntityType($postEntity, 'Post');

        $metadata->addKeyProperty($postsEntityType, 'PostID', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($postsEntityType, 'Author', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($postsEntityType, 'Date', EdmPrimitiveType::DATETIME);
        $metadata->addPrimitiveProperty($postsEntityType, 'DateGmt', EdmPrimitiveType::DATETIME);
        $metadata->addPrimitiveProperty($postsEntityType, 'Content', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'Title', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'Excerpt', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'Status', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'CommentStatus', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'PingStatus', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'Password', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'Name', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'ToPing', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'Pinged', EdmPrimitiveType::STRING);
        $metadata->addETagProperty($postsEntityType, 'Modified', EdmPrimitiveType::DATETIME);
        $metadata->addPrimitiveProperty($postsEntityType, 'ModifiedGmt', EdmPrimitiveType::DATETIME);
        $metadata->addPrimitiveProperty($postsEntityType, 'ContentFiltered', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'ParentID', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($postsEntityType, 'Guid', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'MenuOrder', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($postsEntityType, 'Type', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'MimeType', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($postsEntityType, 'CommentCount', EdmPrimitiveType::INT32);

        //Register the entity (resource) type 'Tag'
        $tagsEntityType = $metadata->addEntityType($tagEntity, 'Tag');

        $metadata->addKeyProperty($tagsEntityType, 'TagID', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($tagsEntityType, 'Name', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($tagsEntityType, 'Slug', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($tagsEntityType, 'Description', EdmPrimitiveType::STRING);

        //Register the entity (resource) type 'Category'
        $catsEntityType = $metadata->addEntityType($categoryEntity, 'Category');

        $metadata->addKeyProperty($catsEntityType, 'CategoryID', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($catsEntityType, 'Name', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($catsEntityType, 'Slug', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($catsEntityType, 'Description', EdmPrimitiveType::STRING);

        //Register the entity (resource) type 'Comment'
        $commentsEntityType = $metadata->addEntityType($commentEntity, 'Comment');

        $metadata->addKeyProperty($commentsEntityType, 'CommentID', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($commentsEntityType, 'PostID', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($commentsEntityType, 'Author', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($commentsEntityType, 'AuthorEmail', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($commentsEntityType, 'AuthorUrl', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($commentsEntityType, 'AuthorIp', EdmPrimitiveType::STRING);
        $metadata->addETagProperty($commentsEntityType, 'Date', EdmPrimitiveType::DATETIME);
        $metadata->addPrimitiveProperty($commentsEntityType, 'DateGmt', EdmPrimitiveType::DATETIME);
        $metadata->addPrimitiveProperty($commentsEntityType, 'Content', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($commentsEntityType, 'Karma', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($commentsEntityType, 'Approved', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($commentsEntityType, 'Agent', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($commentsEntityType, 'Type', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($commentsEntityType, 'ParentID', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($commentsEntityType, 'UserID', EdmPrimitiveType::INT32);

        //Register the entity (resource) type 'User'
        $usersEntityType = $metadata->addEntityType($userEntity, 'User');

        $metadata->addKeyProperty($usersEntityType, 'UserID', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($usersEntityType, 'Login', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($usersEntityType, 'Nicename', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($usersEntityType, 'Email', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($usersEntityType, 'Url', EdmPrimitiveType::STRING);
        $metadata->addETagProperty($usersEntityType, 'Registered', EdmPrimitiveType::DATETIME);
        $metadata->addPrimitiveProperty($usersEntityType, 'Status', EdmPrimitiveType::INT16);
        $metadata->addPrimitiveProperty($usersEntityType, 'DisplayName', EdmPrimitiveType::STRING);

        $postsResourceSet = $metadata->addResourceSet('Posts', $postsEntityType);
        $tagsResourceSet = $metadata->addResourceSet('Tags', $tagsEntityType);
        $catsResourceSet = $metadata->addResourceSet('Categories', $catsEntityType);
        $commentsResourceSet = $metadata->addResourceSet('Comments', $commentsEntityType);
        $usersResourceSet = $metadata->addResourceSet('Users', $usersEntityType);

        //associations of Post
        $metadata->addResourceReferenceProperty($postsEntityType, 'User', $usersResourceSet);
        $metadata->addResourceSetReferenceProperty($postsEntityType, 'Tags', $tagsResourceSet);
        $metadata->addResourceSetReferenceProperty($postsEntityType, 'Categories', $catsResourceSet);
        $metadata->addResourceSetReferenceProperty($postsEntityType, 'Comments', $commentsResourceSet);
        //associations of Tag
        $metadata->addResourceSetReferenceProperty($tagsEntityType, 'Posts', $postsResourceSet);
        //associations of Category
        $metadata->addResourceSetReferenceProperty($catsEntityType, 'Posts', $postsResourceSet);
        //associations of Comment
        $metadata->addResourceReferenceProperty($commentsEntityType, 'User', $usersResourceSet);
        $metadata->addResourceReferenceProperty($commentsEntityType, 'Post', $postsResourceSet);
        //associations of User
        $metadata->addResourceSetReferenceProperty($usersEntityType, 'Posts', $postsResourceSet);
        $metadata->addResourceSetReferenceProperty($usersEntityType, 'Comments', $commentsResourceSet);

        return $metadata;
    }

    public static function getEntityMapping()
    {
        if (null !== self::$_entityMapping) {
            self::$_entityMapping = [
            'Post' => [
                '$MappedTable$'   => 'wp_posts',
                'PostID'          => 'ID',
                'Author'          => 'post_author',
                'Date'            => 'post_date',
                'DateGmt'         => 'post_date_gmt',
                'Content'         => 'post_content',
                'Title'           => 'post_title',
                'Excerpt'         => 'post_excerpt',
                'Status'          => 'post_status',
                'CommentStatus'   => 'comment_status',
                'PingStatus'      => 'ping_status',
                'Password'        => 'post_password',
                'Name'            => 'post_name',
                'ToPing'          => 'to_ping',
                'Pinged'          => 'pinged',
                'ModifiedGmt'     => 'post_modified_gmt',
                'ContentFiltered' => 'post_content_filtered',
                'ParentID'        => 'post_parent',
                'Guid'            => 'guid',
                'MenuOrder'       => 'menu_order',
                'Type'            => 'post_type',
                'MimeType'        => 'post_mime_type',
                'CommentCount'    => 'comment_count',
              ],

            'Tag' => [
                '$MappedTable$' => 'wp_terms',
                'TagID'         => 't.term_id',
                'Name'          => 't.name',
                'Slug'          => 't.slug',
                'Description'   => 'tt.description',
            ],

            'Category' => [
                '$MappedTable$' => 'wp_terms',
                'CategoryID'    => 't.term_id',
                'Name'          => 't.name',
                'Slug'          => 't.slug',
                'Description'   => 'tt.description',
            ],

            'Comment' => [
                '$MappedTable$' => 'wp_comments',
                'CommentID', 'comment_id',
                'PostID', 'comment_post_id',
                'Author', 'comment_author',
                'AuthorEmail', 'comment_author',
                'AuthorUrl', 'comment_author_url',
                'AuthorIp', 'comment_author_email',
                'DateGmt', 'comment_date',
                'Content', 'comment_content',
                'Karma', 'comment_karma',
                'Approved', 'comment_approved',
                'Agent', 'comment_agent',
                'Type', 'comment_type',
                'ParentID', 'comment_parent',
                'UserID', 'user_id',
            ],

            'User' => [
                '$MappedTable$' => 'wp_users',
                'UserID'        => 'ID',
                'Login'         => 'user_login',
                'Nicename'      => 'user_nicename',
                'Email'         => 'user_email',
                'Url'           => 'user_url',
                'Registered'    => 'user_registered',
                'Status'        => 'user_status',
                'DisplayName'   => 'display_name',
            ],
            ];
        }

        return self::$_entityMapping;
    }
}
