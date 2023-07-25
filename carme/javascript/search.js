function change()
{
  var brands = document.querySelectorAll(".Brands input[type='checkbox']");
  var types = document.querySelectorAll(".Types input[type='checkbox']");
  var seaters = document.querySelectorAll(".Seaters input[type='checkbox']");
  var filters =
  {
    brands: getClassOfCheckedCheckboxes(brands),
    types: getClassOfCheckedCheckboxes(types),
    seaters: getClassOfCheckedCheckboxes(seaters)
  };

  filterResults(filters);

}

function getClassOfCheckedCheckboxes(checkboxes)
{
  var classes = [];

  if (checkboxes && checkboxes.length > 0)
  {
    for (var i = 0; i < checkboxes.length; i++)
    {
      var cb = checkboxes[i];

      if (cb.checked)
      {
        classes.push(cb.getAttribute("rel"));
      }
    }
  }

  return classes;
}

function filterResults(filters)
{
  var rElems = document.querySelectorAll(".result .filterDiv");
  var hiddenElems = [];

  if (!rElems || rElems.length <= 0)
  {
    return;
  }

  for (var i = 0; i < rElems.length; i++)
  {
    var el = rElems[i];

    if (filters.brands.length > 0)
    {
      var isHidden = true;

      for (var j = 0; j < filters.brands.length; j++)
      {
        var filter = filters.brands[j];

        if (el.classList.contains(filter)) {
          isHidden = false;
          break;
        }
      }

      if (isHidden)
      {
        hiddenElems.push(el);
      }
    }

    if (filters.types.length > 0)
    {
      var isHidden = true;

      for (var j = 0; j < filters.types.length; j++)
      {
        var filter = filters.types[j];

        if (el.classList.contains(filter))
        {
          isHidden = false;
          break;
        }
      }

      if (isHidden)
      {
        hiddenElems.push(el);
      }
    }

    if (filters.seaters.length > 0)
    {
      var isHidden = true;

      for (var j = 0; j < filters.seaters.length; j++)
      {
        var filter = filters.seaters[j];

        if (el.classList.contains(filter))
        {
          isHidden = false;
          break;
        }
      }

        if (isHidden)
        {
          hiddenElems.push(el);
        }
    }
  }

  for (var i = 0; i < rElems.length; i++)
  {
    rElems[i].style.display = "block";
  }

  if (hiddenElems.length <= 0)
  {
    return;
  }

  for (var i = 0; i < hiddenElems.length; i++)
  {
    hiddenElems[i].style.display = "none";
  }
}