<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[FormViewPermissions]].
 *
 * @see FormViewPermissions
 */
class FormViewPermissionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FormViewPermissions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FormViewPermissions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
