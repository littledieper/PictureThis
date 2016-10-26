{ToolWithStroke} = require './base'
{createShape} = require '../core/shapes'


module.exports = class Crop extends ToolWithStroke

  name: 'Crop'
  iconName: 'crop'

  begin: (x, y, lc) ->
    @currentShape = createShape('Rectangle', {
      x, y, @strokeWidth,
      strokeColor: lc.getColor('primary'),
      fillColor: lc.getColor('secondary')})

  continue: (x, y, lc) ->
    @currentShape.width = x - @currentShape.x
    @currentShape.height = y - @currentShape.y
    lc.drawShapeInProgress(@currentShape)

  end: (x, y, lc) ->
    lc.saveShape(@currentShape)
