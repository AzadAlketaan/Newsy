import React, { useState, useEffect } from "react";
import { Helmet } from 'react-helmet-async';
// @mui
import { Pagination, Grid, Container, Stack, Typography } from '@mui/material';
import { DemoContainer } from '@mui/x-date-pickers/internals/demo';
import { LocalizationProvider } from '@mui/x-date-pickers-pro';
import { AdapterDayjs } from '@mui/x-date-pickers-pro/AdapterDayjs';
import { DateRangePicker } from '@mui/x-date-pickers-pro/DateRangePicker';

import { ArticleCard, ArticlesSearch, ArticleFilterSidebar } from '../sections/@dashboard/articles';

import usePagination from "../utils/Pagination";

import axios from "../axios-instance";
// ----------------------------------------------------------------------

export default function ArticlePage() {
  
  const [openFilter, setOpenFilter] = useState(false);
  const [FILTERS, setFilters] = useState(false);
  const [ARTICLES, setArticles] = useState([]);
  const [PAGE, setPage] = useState(1);
  const [LastPage, setLastPage] = useState(1);
  const [dateRange, setDateRange] = useState([]);
  const PER_PAGE = 10;

  const handleOpenFilter = () => {
    setOpenFilter(true);
  };

  const handleCloseFilter = () => {
    setOpenFilter(false);
  };

  const fetchArticles = async (CategoryID, SourceID, AuthorID, query) => {
    const { data } = await axios.get("/articles",
    {
      params:
      {
        source_id: SourceID ? SourceID[0] : null,
        fromDate: dateRange[0] ? dateRange[0].$d  : null,
        toDate: dateRange[1] ? dateRange[1].$d : null,
        category_id: CategoryID ? CategoryID[0] : null,
        language_id: null,
        country_id: null,
        author_id: AuthorID ? AuthorID[0] : null,
        search_text: query ?? '',
        title: null,
        limit: PER_PAGE,
        page: PAGE
      }
    });
    setArticles(data.data.articles);
    setLastPage(data.data.lastPage);
  };

    useEffect(() => {
      fetchArticles();
    }, [PAGE, dateRange]);

    const handleChange = (e, p) => {
      setPage(p);
    };
  
  return (
    <>
      <Helmet>
        <title> Articles </title>
      </Helmet>

      <Container>
        <Stack direction="row" alignItems="center" justifyContent="space-between" mb={5}>
          <Typography variant="h4" gutterBottom>
            Explore Articles
          </Typography>
        </Stack>
        <LocalizationProvider dateAdapter={AdapterDayjs}>
          <DemoContainer components={['DateRangePicker']}>
            <DateRangePicker localeText={{ start: 'From', end: 'to' }}
            onChange={(newValue) => setDateRange(newValue)}
            />
          </DemoContainer>
        </LocalizationProvider>
        <Stack direction="row" flexWrap="wrap-reverse" alignItems="center" justifyContent="flex-end" sx={{ mb: 5 }}>
          <Stack direction="row" spacing={1} flexShrink={0} sx={{ my: 1 }}>
            <ArticleFilterSidebar
              openFilter={openFilter}
              onOpenFilter={handleOpenFilter}
              onCloseFilter={handleCloseFilter}
              fetchArticles= {fetchArticles}
            />
          </Stack>
        </Stack>

        <Stack mb={5} direction="row" alignItems="center" justifyContent="space-between">
          <ArticlesSearch fetchArticles= {fetchArticles} />
        </Stack>

        <Grid container spacing={3}>
          {ARTICLES.map((article, index) => (
            <ArticleCard key={article.id} article={article} index={index} />
          ))}
        </Grid>
        <Pagination
          count={LastPage}
          size="large"
          page={PAGE}
          variant="outlined"
          shape="rounded"
          onChange={handleChange}
        />
      </Container>
    </>
  );
}
