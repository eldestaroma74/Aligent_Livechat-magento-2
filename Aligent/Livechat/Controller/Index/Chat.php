<?php

namespace Aligent\Livechat\Controller\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Message\ManagerInterface;

class Chat implements ActionInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */

    public $scopeConfig;

    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */

    protected $configWriter;

    /**
     * @var \Magento\Framework\App\Config\ConfigResource\ConfigInterface
     */

    protected $configInterface;

    /**
     * @var \Magento\Framework\App\Request\Http
     */

    protected $request;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $pageFactory;

    /**
     * @var \Magento\Framework\App\Action\Context
     */
    protected $context;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;


    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param WriterInterface $configWriter
     * @param ConfigInterface $configInterface
     * @param Http $request
     * @param ResultFactory $resultFactory
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        WriterInterface $configWriter,
        ConfigInterface $configInterface,
        Http $request,
        ResultFactory $resultFactory,
        Context $context,
        PageFactory $pageFactory,
        ManagerInterface $messageManager

    )
    {
        $this->configWriter = $configWriter;
        $this->scopeConfig = $scopeConfig;
        $this->configInterface = $configInterface;
        $this->request = $request;
        $this->resultFactory = $resultFactory;
        $this->pageFactory = $pageFactory;
        $this->messageManager = $messageManager;

    }
    public function execute()
    {

        $post = (array)$this->request->getPost();

        if (!empty($post)) {
            // Retrieve form data
            $livechat_license_number = $post['livechat_license_number'];
            $livechat_groups = $post['livechat_groups'];
            $livechat_params = $post['livechat_params'];

            $livechat_license_number_path = "livechat/general/license";
            $livechat_groups_path  = "livechat/advanced/group";
            $livechat_params_path = "livechat/advanced/params";

            $livechat_license_number_value=$this->scopeConfig->getValue("$livechat_license_number_path", $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
            if($livechat_license_number_value){
                $this->configInterface->saveConfig($livechat_license_number_path, $livechat_license_number, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,  $scopeId = 0);
            }else{
                $this->configWriter->save($livechat_license_number_path, $livechat_license_number, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
            }

            $livechat_groups_path_value=$this->scopeConfig->getValue("$livechat_groups_path", $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
            if($livechat_groups_path_value){
                $this->configInterface->saveConfig($livechat_groups_path, $livechat_groups, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,  $scopeId = 0);
            }else{
                $this->configWriter->save($livechat_groups_path, $livechat_groups, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
            }

            $livechat_params_value=$this->scopeConfig->getValue("$livechat_params_path", $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
            if($livechat_params_value){
                $this->configInterface->saveConfig($livechat_params_path, $livechat_params, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,  $scopeId = 0);
            }else{
                $this->configWriter->save($livechat_params_path, $livechat_params, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
            }

            $this->messageManager->addSuccessMessage('Chat form Submitted done !');


            $resultRedirect1 = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect1->setUrl('/aligentlivechat/index/chat');

            return $resultRedirect1;
        }
       return $this->pageFactory->create();
    }
}