<?php
namespace UserMeta\Wpml2;

/**
 * Write wpml-config.xml into user-meta-pro directory
 * 
 * @author Khaled Hossain
 *        
 * @since 1.4
 */
class WpmlConfigXml
{

    /**
     *
     * @var object XMLWriter
     */
    private $writer;

    function __construct()
    {
        $this->writer = new \XMLWriter();
    }

    /**
     * Write generated xml to file
     */
    public function writeToFile()
    {
        global $userMeta;
        if (! is_writable($userMeta->pluginPath))
            return;
        
        $this->writer->openURI($userMeta->pluginPath . '/wpml-config.xml');
        $this->write();
    }

    /**
     * Echo generated output
     */
    public function generate()
    {
        $this->writer->openURI('php://output');
        $this->write();
    }

    /**
     * Write xml file
     */
    private function write()
    {
        // $this->writer->startDocument('1.0','UTF-8');
        $this->writer->setIndent(4);
        $this->writer->startElement('wpml-config');
        $this->writer->startElement('admin-texts');
        
        $this->writeFields();
        $this->writeForms();
        $this->writeEmails();
        $this->writeSettings();
        
        $this->writer->endDocument();
        $this->writer->flush();
    }

    /**
     * user_meta_fields
     */
    private function writeFields()
    {
        global $userMeta;
        $fields = $userMeta->getData('fields');
        if (is_array($fields)) {
            $this->writer->startElement('key');
            $this->writer->writeAttribute('name', 'user_meta_fields');
            foreach ($fields as $id => $field) {
                $this->_writeSingleField($id, $field);
            }
            $this->writer->endElement();
        }
    }

    /**
     * user_meta_forms
     */
    private function writeForms()
    {
        global $userMeta;
        $forms = $userMeta->getData('forms');
        if (is_array($forms)) {
            $this->writer->startElement('key');
            $this->writer->writeAttribute('name', 'user_meta_forms');
            foreach ($forms as $formID => $form) {
                $this->writer->startElement('key');
                $this->writer->writeAttribute('name', $formID);
                
                if (! empty($form['fields']) && is_array($form['fields'])) {
                    $this->writer->startElement('key');
                    $this->writer->writeAttribute('name', 'fields');
                    foreach ($form['fields'] as $fieldID => $field) {
                        if (! (! empty($field['field_title']) || ! empty($field['description']) || ! empty($field['options'])))
                            continue;
                        
                        $this->_writeSingleField($fieldID, $field);
                    }
                    $this->writer->endElement();
                }
                if (! empty($form['button_title']))
                    $this->attWriter('button_title');
                
                $this->writer->endElement();
            }
            $this->writer->endElement();
        }
    }

    private function _writeSingleField($id, $field)
    {
        $this->writer->startElement('key');
        $this->writer->writeAttribute('name', $id);
        
        if (! empty($field['field_title']))
            $this->attWriter('field_title');
        if (! empty($field['placeholder']))
            $this->attWriter('placeholder');
        if (! empty($field['description']))
            $this->attWriter('description');
        if (! empty($field['options']))
            $this->_writeOptionsLabels($field['options']);
        
        $this->writer->endElement();
    }

    /**
     * user_meta_emails
     */
    private function writeEmails()
    {
        global $userMeta;
        $emails = $userMeta->getData('emails');
        if (is_array($emails)) {
            $this->writer->startElement('key');
            $this->writer->writeAttribute('name', 'user_meta_emails');
            foreach ($emails as $key1 => $val1) {
                $this->writer->startElement('key');
                $this->writer->writeAttribute('name', $key1);
                if (is_array($val1)) {
                    foreach ($val1 as $ke2 => $val2) {
                        $this->writer->startElement('key');
                        $this->writer->writeAttribute('name', $ke2);
                        if (is_array($val2)) {
                            foreach ($val2 as $key3 => $val3) {
                                $this->writer->startElement('key');
                                $this->writer->writeAttribute('name', $key3);
                                $this->attWriter('subject');
                                $this->attWriter('body');
                                $this->writer->endElement();
                            }
                        }
                        $this->writer->endElement();
                    }
                }
                $this->writer->endElement();
            }
            $this->writer->endElement();
        }
    }

    /**
     * user_meta_settings
     */
    private function writeSettings()
    {
        global $userMeta;
        $this->writer->startElement('key');
        $this->writer->writeAttribute('name', 'user_meta_settings');
        
        $this->writer->startElement('key');
        $this->writer->writeAttribute('name', 'login');
        $this->writer->startElement('key');
        $this->writer->writeAttribute('name', 'loggedin_profile');
        $this->attWriter('*');
        $this->writer->endElement();
        $this->writer->endElement();
        
        $this->writer->startElement('key');
        $this->writer->writeAttribute('name', 'text');
        $this->attWriter('*');
        $this->writer->endElement();
        
        $this->writer->endElement();
    }

    private function attWriter($attName)
    {
        $this->writer->startElement('key');
        $this->writer->writeAttribute('name', $attName);
        $this->writer->endElement();
    }

    private function _writeOptionsLabels($options)
    {
        if (! is_array($options))
            return;
        
        $this->writer->startElement('key');
        $this->writer->writeAttribute('name', 'options');
        foreach ($options as $id => $option) {
            $this->writer->startElement('key');
            $this->writer->writeAttribute('name', $id);
            $this->attWriter('label');
            $this->writer->endElement();
        }
        $this->writer->endElement();
    }
}
