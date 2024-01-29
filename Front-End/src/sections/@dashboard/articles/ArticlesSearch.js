import { useState, useEffect } from "react";
import PropTypes from 'prop-types';

// @mui
import { styled } from '@mui/material/styles';
import { Autocomplete, InputAdornment, Popper, TextField } from '@mui/material';
// components
import Iconify from '../../../components/iconify';

import axios from "../../../axios-instance";

// ----------------------------------------------------------------------

const StyledPopper = styled((props) => <Popper placement="bottom-start" {...props} />)({
  width: '280px !important',
});

// ----------------------------------------------------------------------

ArticlesSearch.propTypes = {
  fetchArticles: PropTypes.func
};

export default function ArticlesSearch({ fetchArticles }) {

  const [QUERY, setQuery] = useState('empty');
  
  const onTyping = (query) => {
    setQuery(query);
  };

  useEffect(() => {
    if(QUERY !== 'empty')
      fetchArticles(null, null, null, QUERY);
  }, [QUERY]);

  return (
    
    <TextField
     label="Search..."
     id="outlined-basic"
    variant="outlined"
     onChange={(event) => {
        onTyping(event.target.value);
      }}
    />
  );
}
