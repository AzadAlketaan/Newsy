import React, { useState, useEffect } from "react";
import {useAuthHeader } from 'react-auth-kit';
import { Helmet } from 'react-helmet-async';

// @mui
import { Pagination, Container, Typography } from '@mui/material';
// components
import { NewsfeedList } from '../sections/@dashboard/newsfeeds';

import axios from "../axios-instance";
// ----------------------------------------------------------------------

export default function NewsfeedsPage() {

  const authHeader = useAuthHeader();
  const [NEWSFEEDS, setNewsFeeds] = useState([]);
  const [PAGE, setPage] = useState(1);
  const [LastPage, setLastPage] = useState(1);
  const PER_PAGE = 10;
  
  const fetchNewsFeeds = async () => {
    const { data } = await axios.get(`/articles/newsFeed`,
    { headers: {"Authorization" : authHeader()},
    params:
    {
      limit: PER_PAGE,
      page: PAGE
    }}
    );
    setNewsFeeds(data.data.articles);
    setLastPage(data.data.lastPage);
  };

  useEffect(() => {
    fetchNewsFeeds();
  }, [PAGE]);
  
  const handleChange = (e, p) => {
    setPage(p);
  };

  return (
    <>
      <Helmet>
        <title> News Feed </title>
      </Helmet>

      <Container>
        <Typography variant="h4" sx={{ mb: 5 }}>
          Top headlines
        </Typography>
                
        <NewsfeedList newsfeeds={NEWSFEEDS} />
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
