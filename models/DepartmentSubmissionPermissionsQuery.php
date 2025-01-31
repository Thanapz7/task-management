<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[DepartmentSubmissionPermissions]].
 *
 * @see DepartmentSubmissionPermissions
 */
class DepartmentSubmissionPermissionsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DepartmentSubmissionPermissions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DepartmentSubmissionPermissions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
