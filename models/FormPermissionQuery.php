<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FormPermission]].
 *
 * @see FormPermission
 */
class FormPermissionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FormPermission[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FormPermission|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
