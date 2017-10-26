<?php
use app\core\App;
use app\models\Callback;
use app\models\DataProduct;

/**
 * Class ControllerCatalogPrides
 */
class ControllerCatalogLoadFromExcel extends Controller {
    const NAME_LIST_PRODUCTS = 'Export Products Sheet';
    const NAME_LIST_GROUPS = 'Export Groups Sheet';
	private $error = array();
    public $data = [];

	public function index() {
        $this->data['nameFile'] = '1.xlsx';

        if (isset($this->request->post['do_load_from_excel']) && $this->request->post['do_load_from_excel'] == 'y') {
            ini_set('max_execution_time', 0);
            set_time_limit(0);
            $this->loadModels();
            $onlyImages = false;
            if (isset($this->request->post['do_image'])) {
                $onlyImages = true;
            }
            $this->session->data['do_load_from_excel']['success'] = $this->loadFromFile(DIR_UPLOAD . '/' . $this->request->post['nameFile'],$onlyImages);
            $this->response->redirect($this->url->link('catalog/load_from_excel', ['token' => $this->session->data['token']]));
        }
        $this->setOutput();

    }

    protected function loadModels() {
        $this->load->model('catalog/product');
        $this->load->model('catalog/manufacturer');
        $this->load->model('catalog/attribute');
        $this->load->model('catalog/option');

        DataProduct::$ocModel = $this->model_catalog_product;
        DataProduct::$ocModelManufacturer = $this->model_catalog_manufacturer;
        DataProduct::$ocModelAttribute = $this->model_catalog_attribute;
        DataProduct::$ocModelOption = $this->model_catalog_option;

    }

    protected function setOutput() {

        $this->data['error_warning'] = '';
        $this->data['success'] = '';
        if (isset($this->session->data['do_load_from_excel'])) {
            if ($this->session->data['do_load_from_excel']['success']) {
                $this->data['success'] = 'Файл прочитан';
            } else {
                $this->data['error_warning'] = 'Ошибка чтения файла';
            }
            unset($this->session->data['do_load_from_excel']);
        }

        $this->data['title'] = 'Загрузка товаров с Excel';

        $this->document->setTitle($this->data['title']);
        $this->data['header'] = $this->load->controller('common/header');
        $this->data['column_left'] = $this->load->controller('common/column_left');
        $this->data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/load_from_excel', $this->data));
    }

	protected function readFile($excelFile) {

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($excelFile);
        $arrayData = [];
        $arrayData['products'] = [];
        $arrayData['groups'] = [];
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $title = $worksheet->getTitle();
            if ($title == self::NAME_LIST_PRODUCTS) {
                $arrayData['products'] = $worksheet->toArray();
            } elseif ($title == self::NAME_LIST_GROUPS) {
                $arrayData['groups'] = $worksheet->toArray();
            } else {
                $arrayData[$title] = $worksheet->toArray();
            }
        }
        return $arrayData;
    }

    protected function loadFromFile($file, $onlyImages = false) {
        $excel = $this->readFile($file);
        unset($excel['products'][0]);
        $groups = [];
        foreach ($excel['groups'] as $group) {
            $groups[$group[0]] = $group[7];
        }
        DataProduct::$groupsExcel = $groups;
        if ($onlyImages) {
            $this->saveImages($excel['products']);
            return true;
        }
        $this->saveProducts($excel['products']);
        return true;
    }

    protected function saveProducts($dataProducts) {
        DataProduct::$productsExcel = $dataProducts;
        $savedProducts = $this->cache->get('savedProductsFromExcel');
        foreach ($dataProducts as $dataProduct) {
            if (empty($dataProduct[3])) {
                continue;
            }

            $product = new DataProduct();
            $product->loadFromExcelData($dataProduct);
            if (isset($savedProducts[$product->name])) {
                $product->id = $savedProducts[$product->name];
            }
            $product->save();
            $savedProducts[$product->name] = $product->id;
            App::$debug->d($dataProduct);
            break;
        }
        $this->cache->set('savedProductsFromExcel', $savedProducts);
        die();
    }

    protected function saveImages($dataProducts) {
        $images = [];
        foreach ($dataProducts as $dataProduct) {
            $rowImages = explode(',',$dataProduct[15]);
            foreach ($rowImages as $rowImage) {
                $images[] = $rowImage;
            }
        }
        $product = new DataProduct();
        foreach ($images as $image) {
            $res = $product->saveImage($image,true);
            $trying = 1;
            try {
                $size = getimagesize($res);
            } catch (\Exception $e) {
                $this->saveImage($image);
            }
        }
    }
    protected function saveImageRecursive(){

    }
}
?>