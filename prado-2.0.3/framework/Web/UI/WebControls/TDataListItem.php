<?php
/**
 * TDataListItem class file
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the BSD License.
 *
 * Copyright(c) 2004 by Qiang Xue. All rights reserved.
 *
 * To contact the author write to {@link mailto:qiang.xue@gmail.com Qiang Xue}
 * The latest version of PRADO can be obtained from:
 * {@link http://prado.sourceforge.net/}
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Revision: 1.4 $  $Date: 2005/01/25 04:07:57 $
 * @package System.Web.UI.WebControls
 */

/**
 * TDataListItem class
 *
 * A TDataListItem control represents an item in the TDataList control, such
 * as heading section, footer section, or a data item. The data items 
 * are stored in the <b>Items</b> property of TDataList control.
 * The index and data value of the item can be accessed via <b>Index</b>
 * and <b>Data</b> properties, respectively.
 *
 * Namespace: System.Web.UI.WebControls
 *
 * Properties
 * - <b>ItemIndex</b>, mixed
 *   <br>Gets or sets the index of the data item in the Items collection of datalist.
 * - <b>Data</b>, mixed
 *   <br>Gets or sets the value of the data item.
 * - <b>Type</b>, mixed
 *   <br>Gets or sets the type of the item (Header, Footer, Item, AlternatingItem, EditItem, SelectedItem, Separator)
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version v1.0, last update on 2004/08/13 21:44:52
 * @package System.Web.UI.WebControls
 */
class TDataListItem extends TWebControl
{
	/**
	 * Header
	 */
	const TYPE_HEADER='Header';
	/**
	 * Footer
	 */
	const TYPE_FOOTER='Footer';
	/**
	 * Data item
	 */
	const TYPE_ITEM='Item';
	/**
	 * Alternating data item
	 */
	const TYPE_ALTERNATING_ITEM='AlternatingItem';
	/**
	 * Selected item
	 */
	const TYPE_SELECTED_ITEM='SelectedItem';
	/**
	 * Edit item
	 */
	const TYPE_EDIT_ITEM='EditItem';
	/**
	 * Separator
	 */
	const TYPE_SEPARATOR='Separator';
	/**
	 * index of the data item
	 * @var mixed
	 */
	private $index='';
	/**
	 * value of the data item
	 * @var mixed
	 */
	private $data=null;
	/**
	 * type of the TDataListItem
	 * @var string
	 */
	private $type='';

	/**
	 * Constructor.
	 * Initializes the type to 'Item'.
	 */
	public function __construct()
	{
		$this->type=self::TYPE_ITEM;
		parent::__construct();
	}

	/**
	 * @return mixed the index of the data item
	 */
	public function getItemIndex()
	{
		return $this->index;
	}

	/**
	 * Sets the index of the data item
	 * @param mixed the data item index
	 */
	public function setItemIndex($value)
	{
		$this->index=$value;
	}

	/**
	 * @return mixed the value of the data item
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Sets the value of the data item
	 * @param mixed the value of the data item
	 */
	public function setData($value)
	{
		$this->data=$value;
	}

	/**
	 * @return string the item type 
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Sets the item type
	 * @param string the item type
	 */
	public function setType($value)
	{
		$this->type=$value;
	}

	/**
	 * Handles <b>OnBubbleEvent</b>.
	 * This method overrides parent's implementation to bubble
	 * <b>OnItemCommand</b> event if an <b>OnCommand</b>
	 * event is bubbled from a child control.
	 * This method should only be used by control developers.
	 * @param TControl the sender of the event
	 * @param TEventParameter event parameter
	 * @return boolean whether the event bubbling should stop here.
	 */
	protected function onBubbleEvent($sender,$param)
	{
		if($param instanceof TCommandEventParameter)
		{
			$ce=new TDataListCommandEventParameter;
			$ce->name=$param->name;
			$ce->parameter=$param->parameter;
			$ce->source=$sender;
			$ce->item=$this;
			$this->raiseBubbleEvent($this,$ce);
			return true;
		}
		else
			return false;
	}

	/**
	 * Returns the attributes to be rendered.
	 * @return ArrayObject attributes to be rendered
	 */
	protected function getAttributesToRender()
	{
		$attributes=parent::getAttributesToRender();
		unset($attributes['id']);
		return $attributes;
	}

	/**
	 * Renders the attributes.
	 * @param array|null the attributes to be rendered, if null {@link getAttributesToRender()} will be invoked to get the attributes
	 * @return string the rendering result
	 * @see getAttributesToRender()
	 */
	public function renderAttributes($attributes=null)
	{
		if(is_null($attributes))
			$attributes=$this->getAttributesToRender();
		$attr='';
		foreach($attributes as $name=>$value)
			$attr.="$name=\"$value\" ";
		return trim($attr);
	}
}

?>