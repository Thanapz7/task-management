<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "field_values".
 *
 * @property int $id
 * @property int $record_id
 * @property int $field_id
 * @property string $value ข้อมูลที่อยู่ในฟิลด์
 * @property string $create_at
 * @property string $update_at
 */

class FieldValues extends \yii\db\ActiveRecord
{
    // ส่วนของการตรวจสอบข้อมูล
    public function rules()
    {
        return [
            [['record_id', 'field_id'], 'integer'],
            [['value'], 'string'],
            [['create_at', 'update_at'], 'safe'],
        ];
    }

    // ฟังก์ชั่นสำหรับอัปโหลดไฟล์
    public function uploadFile($file, $recordId)
    {
        // ตรวจสอบว่าไฟล์ได้รับการอัปโหลดหรือไม่
        if ($file === null || $file->getHasError()) {
            Yii::error('ไม่พบไฟล์หรือไฟล์ไม่ถูกต้อง');
            return false;
        }

        // กำหนดโฟลเดอร์ที่เก็บไฟล์
        $directory = Yii::getAlias('@app/web/uploads');

        // ตรวจสอบว่าโฟลเดอร์มีอยู่แล้วหรือไม่ ถ้าไม่สร้างใหม่
        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true)) {
                Yii::error('ไม่สามารถสร้างโฟลเดอร์: ' . $directory);
                return false;
            }
        }

        // สร้างชื่อไฟล์ที่ไม่ซ้ำ
        $fileName = uniqid($recordId . '_') . '.' . $file->extension;
        $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;

        // บันทึกไฟล์ลงในเซิร์ฟเวอร์
        if ($file->saveAs($filePath)) {
            Yii::debug('บันทึกไฟล์สำเร็จ: ' . $filePath, 'file-upload');
            return 'uploads/' . $fileName; // เก็บ path สั้นไว้ในฐานข้อมูล
        } else {
            Yii::error('ไม่สามารถบันทึกไฟล์ลงที่: ' . $filePath);
            return false;
        }
    }
}
