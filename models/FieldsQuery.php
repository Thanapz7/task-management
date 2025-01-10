<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Fields]].
 *
 * @see Fields
 */
class FieldsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Fields[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Fields|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
