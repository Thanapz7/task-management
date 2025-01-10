<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Records]].
 *
 * @see Records
 */
class RecordsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Records[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Records|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
