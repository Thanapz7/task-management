<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Forms]].
 *
 * @see Forms
 */
class FormsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Forms[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Forms|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
