<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FieldValues]].
 *
 * @see FieldValues
 */
class FieldValuesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FieldValues[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FieldValues|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
