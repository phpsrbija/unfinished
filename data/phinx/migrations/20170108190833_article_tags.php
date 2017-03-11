<?php

use Phinx\Migration\AbstractMigration;
use MysqlUuid\Formats\Binary;
use MysqlUuid\Uuid;

/**
 * Old data migration need to happend now, since this table is last that is critical in order to execute required sql.
 *
 * Class ArticleTags
 */
class ArticleTags extends AbstractMigration
{
    public function up()
    {
        $this->table('article_tags', ['id' => true, 'primary_key' => 'id'])
            ->addColumn('tag_uuid', 'binary', ['limit' => 16])
            ->addColumn('article_uuid', 'binary', ['limit' => 16])
            ->addForeignKey('article_uuid', 'articles', 'article_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('tag_uuid', 'tags', 'tag_uuid', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();

//        $this->insertDummyData();
        $this->migrateOldArticles();
    }

    public function down()
    {
        $this->dropTable('article_tags');
    }

    private function migrateOldArticles()
    {
        $sql = file_get_contents(__DIR__ . "/migratedArticles.sql");
        if ($this->execute(addslashes($sql))) {
            echo 'migrated articles...';
        }
    }

    public function insertDummyData()
    {
        $tagIds = [];
        $tags   = $this->fetchAll('select tag_uuid from tags;');
        foreach($tags as $tag){
            $tagIds[] = $tag['tag_uuid'];
        }

        $articles = $this->fetchAll('select article_uuid from articles;');
        foreach($articles as $article){
            $tagId = $tagIds[array_rand($tagIds)];
            $data  = [
                'tag_uuid'     => (new Uuid($tagId, new Binary()))->toFormat(new Binary()),
                'article_uuid' => (new Uuid($article['article_uuid'], new Binary()))->toFormat(new Binary()),
            ];

            $this->insert('article_tags', $data);

            $newTagId = $tagIds[array_rand($tagIds)];
            while($tagId === $newTagId){
                $newTagId = $tagIds[array_rand($tagIds)];
            }
            $data = [
                'tag_uuid'     => (new Uuid($newTagId, new Binary()))->toFormat(new Binary()),
                'article_uuid' => (new Uuid($article['article_uuid'], new Binary()))->toFormat(new Binary()),
            ];

            $this->insert('article_tags', $data);
        }
    }
}
