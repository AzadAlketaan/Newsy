import { useState, useEffect } from "react";
import PropTypes from 'prop-types';
// @mui
import {
  Box,
  Stack,
  Button,
  Drawer,
  Divider,
  Checkbox,
  FormGroup,
  IconButton,
  Typography,
  FormControlLabel,
} from '@mui/material';
// components
import Iconify from '../../../components/iconify';
import Scrollbar from '../../../components/scrollbar';
import axios from "../../../axios-instance";

// ----------------------------------------------------------------------

export const SORT_BY_OPTIONS = [
  { value: 'featured', label: 'Featured' },
  { value: 'newest', label: 'Newest' },
  { value: 'priceDesc', label: 'Price: High-Low' },
  { value: 'priceAsc', label: 'Price: Low-High' },
];

// ----------------------------------------------------------------------

ShopFilterSidebar.propTypes = {
  openFilter: PropTypes.bool,
  onOpenFilter: PropTypes.func,
  onCloseFilter: PropTypes.func,
  fetchArticles: PropTypes.func
};

export default function ShopFilterSidebar({ openFilter, onOpenFilter, onCloseFilter, fetchArticles}) {
  
  const [FILTER_SOURCE_OPTIONS, setSourceOptions] = useState([]);
  const [FILTER_CATEGORY_OPTIONS, setCategoryOptions] = useState([]);
  const [FILTER_AUTHOR_OPTIONS, setAuthorOptions] = useState([]);

  const [CategoryID, setCategoryID] = useState([]);
  const [SourceID, setSourceID] = useState([]);
  const [AuthorID, setAuthorID] = useState([]);

  const [isCleared, setIsCleared] = useState(0);

  const onChangeCatigory = (checked, item) => {
    setCategoryID([item]);
  };

  const onChangeSource = (checked, item) => {
    setSourceID([item]);
  };

  const onChangeAuthor = (checked, item) => {
    setAuthorID([item]);
  };

  const clearALL = () => {
    setCategoryID([]);
    setSourceID([]);
    setAuthorID([]);
    setIsCleared(1);
  }

  const fetchSourceOptions = async () => {
    const { data } = await axios.get("/utils/sources/");
    setSourceOptions(data.data);
  };
  const fetchCategoryOptions = async () => {
    const { data } = await axios.get("/utils/categories/");
    setCategoryOptions(data.data);
  };
  
  const fetchAuthorOptions = async () => {
    const { data } = await axios.get("/utils/authors/");
    setAuthorOptions(data.data);
  };

  useEffect(() => {
    fetchSourceOptions();
    fetchCategoryOptions();
    fetchAuthorOptions();
  }, []);

  useEffect(() => {
    if(CategoryID.length !== 0 || SourceID.length !== 0 || AuthorID.length !== 0 || isCleared)
      fetchArticles(CategoryID, SourceID, AuthorID);
  }, [CategoryID, SourceID, AuthorID]);
 
  return (
    <>
      <Button disableRipple color="inherit" endIcon={<Iconify icon="ic:round-filter-list" />} onClick={onOpenFilter}>
        Filters&nbsp;
      </Button>

      <Drawer
        anchor="right"
        open={openFilter}
        onClose={onCloseFilter}
        PaperProps={{
          sx: { width: 280, border: 'none', overflow: 'hidden' },
        }}
      >
        <Stack direction="row" alignItems="center" justifyContent="space-between" sx={{ px: 1, py: 2 }}>
          <Typography variant="subtitle1" sx={{ ml: 1 }}>
            Filters
          </Typography>
          <IconButton onClick={onCloseFilter}>
            <Iconify icon="eva:close-fill" />
          </IconButton>
        </Stack>

        <Divider />

        <Scrollbar>
          <Stack spacing={3} sx={{ p: 3 }}>

            <div>
              <Typography variant="subtitle1" gutterBottom>
              Category
              </Typography>
              <FormGroup>
                {FILTER_CATEGORY_OPTIONS.map((item) => (
                  <FormControlLabel key={item.id} value={item.name} control={<Checkbox
                    checked={CategoryID.includes(item.id)}
                    onChange={(event) => {
                      onChangeCatigory(event.target.checked, item.id);
                    }}
                  />} label={item.name} />
                ))}
              </FormGroup>
            </div>

            <div>
              <Typography variant="subtitle1" gutterBottom>
                Author
              </Typography>
              <FormGroup>
                {FILTER_AUTHOR_OPTIONS.map((item) => (
                  <FormControlLabel key={item.id} value={item.name} control={<Checkbox
                    checked={AuthorID.includes(item.id)}
                    onChange={(event) => {
                      onChangeAuthor(event.target.checked, item.id);
                    }}  
                  />} label={item.name} />
                ))}
              </FormGroup>
            </div>

            <div>
              <Typography variant="subtitle1" gutterBottom>
                Source
              </Typography>
              <FormGroup>
                {FILTER_SOURCE_OPTIONS.map((item) => (
                  <FormControlLabel key={item.id} value={item.name} control={<Checkbox
                    checked={SourceID.includes(item.id)}
                    onChange={(event) => {
                      onChangeSource(event.target.checked, item.id);
                    }}
                  />} label={item.name} />
                ))}
              </FormGroup>
            </div>
            
          </Stack>
        </Scrollbar>

        <Box sx={{ p: 3 }}>
          <Button
            fullWidth
            size="large"
            type="submit"
            color="inherit"
            variant="outlined"
            startIcon={<Iconify icon="ic:round-clear-all"/>}
            onClick={clearALL}
          >
            Clear All
          </Button>
        </Box>
      </Drawer>
    </>
  );
}
